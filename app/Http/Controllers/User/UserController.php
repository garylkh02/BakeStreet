<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use App\Models\User;
use App\Models\Coupon;


class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $userId = $user->id;
        // Count the pending and completed orders
        $pendingOrdersCount = Order::where('user_id', $user->id)
        ->where('status', 'pending')
        ->count();

        $completedOrdersCount = Order::where('user_id', $user->id)
        ->where('status', 'completed')
        ->count();

         // Get the current points of the user
        $currentPoints = $user->loyalty_points;

        // Check if it's the user's birthday month and assign a coupon if it is
        if ($this->isBirthdayMonth($user->birthday)) {
            $this->assignBirthdayCoupon($user->id);
        }

        $availableCoupons = Coupon::where('user_id', $user->id)->where('is_used', 0)->where('expiry_date', '>', now())->exists();

        return view('dashboard', compact('user', 'pendingOrdersCount', 'completedOrdersCount', 'currentPoints', 'availableCoupons'));
    }

    private function isBirthdayMonth($birthday)
    {
        return Carbon::parse($birthday)->format('m') === Carbon::now()->format('m');
    }

    private function assignBirthdayCoupon($userId)
    {
        // Check if the user already has a birthday voucher assigned
        if (!Coupon::where('user_id', $userId)->where('type', 'birthday')->exists()) {
            Coupon::create([
                'user_id' => $userId,
                'code' => strtoupper(Str::random(10)),
                'type' => 'birthday',
                'discount' => 15,
                'expiry_date' => Carbon::now()->endOfMonth(),
            ]);
        }
    }

    public function showUserCoupons()
    {
        $user = Auth::user();
    
        // Fetch available coupons for the logged-in user, filtered by is_used and expiry_date, and sorted by expiry_date
        $availableCoupons = Coupon::where('user_id', $user->id)
                                    ->where('is_used', false)
                                    ->where('expiry_date', '>', now())
                                    ->orderBy('expiry_date', 'asc')
                                    ->get();
        
        // Fetch used coupons for the logged-in user, sorted by expiry_date
        $usedCoupons = Coupon::where('user_id', $user->id)
                                ->where('is_used', true)
                                ->orderBy('expiry_date', 'asc')
                                ->get();
    
        // Fetch expired coupons for the logged-in user, sorted by expiry_date
        $expiredCoupons = Coupon::where('user_id', $user->id)
                                ->where('expiry_date', '<=', now())
                                ->orderBy('expiry_date', 'asc')
                                ->get();
    
        // Check if the user's email is verified
        $isVerified = $user->hasVerifiedEmail();
    
        return view('showcoupons', compact('availableCoupons', 'usedCoupons', 'expiredCoupons', 'isVerified'));
    }
    

    public function showLoyaltyPage()
    {
        $user = Auth::user();
        $userId = $user->id;
        $user = User::find($userId);

        $availableCoupons = Coupon::where('user_id', $user->id)
                                ->where('is_used', false)
                                ->where('expiry_date', '>', now())
                                ->orderBy('expiry_date', 'asc')
                                ->get();
    
        $pointsActivities = LoyaltyPoint::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(23)
                                ->get();
        
        $referralCode = $user->referral_code;
        $isVerified = $user->hasVerifiedEmail(); // Check if the user's email is verified
        
        return view('loyalty', [
            'availableCoupons' => $availableCoupons,
            'pointsActivities' => $pointsActivities,
            'isVerified' => $isVerified, 
            'referralCode' => $referralCode,
        ]);
    }
    

    public function redeemPoints(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->usertype == 'user') {
                $user = auth()->user();
                $userId = $user->id;

                $pointsToRedeem = (int) $request->input('pointsToRedeem');
                $description = $pointsToRedeem == 300 ? '15% off Coupon Redemption' : '30% off Coupon Redemption';
                $discount = $pointsToRedeem == 300 ? 15 : 30; // Set discount based on points to redeem
                
                if ($pointsToRedeem == 300) {
                    $description = '15% off Coupon Redemption';
                    $discount = 15;
                } elseif ($pointsToRedeem == 600) {
                    $description = '30% off Coupon Redemption';
                    $discount = 30;
                } else {
                    return redirect()->back()->with('error', 'Invalid points to redeem.');
                }

                $user = User::find($userId);

                // Check if the user has enough points to redeem
                if ($user->loyalty_points >= $pointsToRedeem) {
                    $user->loyalty_points -= $pointsToRedeem;
                    $user->save();

                    LoyaltyPoint::create([
                        'user_id' => $user->id,
                        'points' => - $pointsToRedeem,
                        'description' => $description,
                    ]);

                    // Create a coupon for the user
                    $coupon = $this->newCoupon($user, $discount);

                    return redirect()->back()->with('success', 'Points successfully redeemed. Coupon code: ' . $coupon->code);
                } else {
                    return redirect()->back()->with('error', 'Insufficient points.');
                }
            }
        }
        return redirect('login')->withErrors(['error' => 'You need to log in first']); 
    }

    protected function newCoupon(User $user, $discount)
    {
        $coupon = Coupon::create([
            'code' => strtoupper(Str::random(10)),
            'discount' => $discount,
            'type' => 'discount',
            'expiry_date' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
        ]);
        return $coupon;
    }


}
