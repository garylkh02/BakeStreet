<x-app-layout>
    @section('content')
    <div class="py-4 pb-2">
        <div class="mx-auto">
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none flex flex-wrap">
                    <li class="flex items-center">
                        <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard &nbsp;&nbsp;</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                        <a href="/loyalty" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp; Loyalty Program</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
    @endif

    @if (!$isVerified)
        <div class="mt-6 text-center px-4 sm:px-8">
            <p class="text-lg md:text-xl text-gray-700">Your email address is unverified.</p>
            <p class="text-md md:text-lg text-gray-700">
                {{ __('To access the loyalty program, please verify your email address.') }}
            </p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-md text-gray-600 dark:text-gray-400 hover:text-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Click here to complete the verification process.') }}
                </button>
            </form>
        </div>
        <script>
            // Refresh the page after 30 seconds (30000 milliseconds)
            setTimeout(function() {
                location.reload();
            }, 30000);
        </script>
    @else
        <div class="text-center pt-2">
            <h1 class="text-2xl md:text-4xl font-semibold text-gray-800 leading-tight">
                {{ __('Loyalty Program') }}
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-4 sm:px-8">
            <div class="container mx-auto mt-7 mb-20">
                <div class="max-w-xl mx-auto bg-white p-5 rounded-lg shadow-md">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 text-center">Points Redemption</h2>

                    <div class="mt-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-700">Your Points</h3>
                            <p class="text-md md:text-lg text-gray-700">Points: {{ Auth::user()->loyalty_points }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-700">Your Referral Code</h3>
                            <div class="flex items-center mt-2">
                                <span class="text-md md:text-lg text-gray-700">{{ $referralCode }}</span>
                                <button onclick="copyReferralCode()" class="ml-4 bg-amber-500 text-white px-3 py-1 rounded-md font-bold hover:bg-orange-500">Copy</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Ways to Earn</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            <li>Place an order - <b>RM 1 spent = 1 Point</b></li>
                            <li>Cake Review - <b>10 Points</b></li>
                            <li>Refer a friend using your referral code - <b>50 Points each</b></li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Ways to Redeem</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            <li>15% Off - 300 Points</li>
                            <li>30% Off - 600 Points</li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Redeem Points</h3>
                        <form action="{{ route('redeem.points') }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-4">
                                <label for="pointsToRedeem" class="block text-gray-700">Select Coupon</label>
                                <select name="pointsToRedeem" id="pointsToRedeem" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                                    <option value="300">15% Off - 300 Points</option>
                                    <option value="600">30% Off - 600 Points</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-orange-500 text-white px-3 py-2 rounded-md font-bold hover:bg-orange-600">Redeem</button>
                        </form>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Your Active Vouchers</h3>
                        <ul class="list-disc list-inside text-gray-700">
                        @if($availableCoupons->isEmpty())
                            <div class="pt-4">
                                <p class="text-md md:text-lg text-gray-600">Oops! You don't have any active vouchers.. &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
                            </div>
                        @else
                        @foreach($availableCoupons as $availableCoupon)
                            <li>
                            @if(is_null($availableCoupon->discount))
                                Free Delivery - Expires on {{ $availableCoupon->expiry_date }}
                            @else
                            {{ floor($availableCoupon->discount) }}% {{ ucfirst($availableCoupon->type) }} - Expires on {{ $availableCoupon->expiry_date }}
                            @endif
                            </li>
                        @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container mx-auto md:mt-8 mb-20">
                <div class="max-w-xl mx-auto md:pt-5">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-700">Good day, {{ Auth::user()->name }}!</h2>

                    <div class="mt-6">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Available points: {{ Auth::user()->loyalty_points }}</h3>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-700">Points Activity</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            @if($pointsActivities->isEmpty())
                                <div class="py-4">
                                    <p class="text-md md:text-lg text-gray-600">Oops! You don't have any activities yet..</p>
                                </div>
                            @else
                            @foreach($pointsActivities as $activity)
                                <li>
                                    <span class="text-md md:text-lg text-gray-700">{{ $activity->description }}: {{ $activity->points }} points</span>
                                    <span class="text-sm md:text-md text-gray-500">on {{ $activity->created_at->format('d M Y') }}</span>
                                </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function copyReferralCode() {
            const referralCode = '{{ $referralCode }}';
            navigator.clipboard.writeText(referralCode).then(() => {
                alert('Referral code copied to clipboard');
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
    @endsection
</x-app-layout>
