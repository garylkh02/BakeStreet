<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Coupon;
use App\Models\LoyaltyPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone' => ['required', 'regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/'],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'], // Validate referral code
            'birthday' => ['required', 'date'], // Add birthday validation
        ])->validate();

        return DB::transaction(function () use ($input) {
            $referrer = null;
            if (!empty($input['referral_code'])) {
                $referrer = User::where('referral_code', $input['referral_code'])->first();
            }

            $user = tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'password' => Hash::make($input['password']),
                'loyalty_points' => 100,
                'referral_code' => $this->generateReferralCode(), // Generate a unique referral code
                'birthday' => $input['birthday'], // Save birthday to the database
            ]), function (User $user) use ($referrer) {

                // Create initial loyalty points
                $this->createLoyaltyPoints($user);
            
                // Award points if referred
                if ($referrer) {
                    $this->awardReferralPoints($user, $referrer);
                }

                // Create coupons for the new user
                $this->firstCoupon($user);
                $this->freedelCoupon($user);
            });

            return $user;
        });
    }

    protected function passwordRules()
    {
        return ['required', 'string', 'min:8', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'];
    }

    /**
     * Create a personal team for the user.
     */
/*     protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    } */

    /**
     * Generate a unique referral code.
     */
    protected function generateReferralCode()
    {
        do {
            $code = Str::random(10);
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Create the first discount coupon for the new user.
     */
    protected function firstCoupon(User $user)
    {
        $coupon = Coupon::create([
            'code' => strtoupper(Str::random(10)),
            'discount' => 15,
            'type' => 'discount',
            'expiry_date' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
        ]);
        return $coupon;
    }

    /**
     * Create the free delivery coupon for the new user.
     */
    protected function freedelCoupon(User $user)
    {
        $freedcoupon = Coupon::create([
            'code' => strtoupper(Str::random(10)),
            'type' => 'free_delivery',
            'expiry_date' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
        ]);
        return $freedcoupon;
    }

    /**
     * Create initial loyalty points for the new user.
     */
    protected function createLoyaltyPoints(User $user)
    {
        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => 100, 
            'description' => 'Welcome Reward', 
        ]);
    }

    /**
     * Award referral points to both the new user and the referrer.
     */
    protected function awardReferralPoints(User $newUser, User $referrer)
    {
        $referrerPoints = 50;
        $referrer->loyalty_points += $referrerPoints;
        $referrer->save();
    
        LoyaltyPoint::create([
            'user_id' => $referrer->id,
            'points' => $referrerPoints,
            'description' => 'Referral Bonus',
        ]);
    
        $newUserPoints = 50; 
        $newUser->loyalty_points += $newUserPoints;
        $newUser->save();
    
        LoyaltyPoint::create([
            'user_id' => $newUser->id,
            'points' => $newUserPoints,
            'description' => 'Referred Bonus',
        ]);
    }
}
