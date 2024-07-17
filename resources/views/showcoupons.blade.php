<x-app-layout>
@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/user/coupons" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp My Coupons</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="text-center pt-2 pb-1">
    <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
        {{ __('My Coupons') }}
    </h1>
</div>
@if (!$isVerified)
<div class="mt-6 text-center">
    <p class="text-xl text-gray-700">Your email address is unverified.</p>
    <p class="text-lg text-gray-700">
        {{ __('To access your coupons, please verify your email address.') }}
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
<div class="container mx-auto py-4 pt-0 px-0 sm:px-6 lg:px-8">
    <div class="mx-auto my-8 p-7 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">Available Coupons</h2>
        @if($availableCoupons->isEmpty())
            <p class="text-gray-600">You have no available coupons.</p>
        @else
            <table class="min-w-full bg-white mt-4">
                <thead class="bg-gray-600 text-white">
                    <tr>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Code</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Discount</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Expiry Date</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Type</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($availableCoupons as $coupon)
                        <tr>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ $coupon->code }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                @if(is_null($coupon->discount))
                                    N/A
                                @else
                                    {{ $coupon->discount }}%
                                @endif
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                            @switch($coupon->type)
                                @case('free_delivery')
                                    Free Delivery
                                    @break
                                @default
                                    {{ ucfirst($coupon->type) }}
                            @endswitch
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                @if($coupon->is_used)
                                    <span class="text-red-500">Used</span>
                                @else
                                    <span class="text-green-500">Available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="mx-auto my-8 p-7 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">Used Coupons</h2>
        @if($usedCoupons->isEmpty())
            <p class="text-gray-600">You have no used coupons.</p>
        @else
            <table class="min-w-full bg-white mt-4">
                <thead class="bg-gray-600 text-white">
                    <tr>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Code</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Discount</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Expiry Date</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Type</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($usedCoupons as $coupon)
                        <tr>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ $coupon->code }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                @if(is_null($coupon->discount))
                                    N/A
                                @else
                                    {{ $coupon->discount }}%
                                @endif
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                            @switch($coupon->type)
                                @case('free_delivery')
                                    Free Delivery
                                    @break
                                @default
                                    {{ ucfirst($coupon->type) }}
                            @endswitch
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                <span class="text-red-500">Used</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="mx-auto my-8 p-7 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">Expired Coupons</h2>
        @if($expiredCoupons->isEmpty())
            <p class="text-gray-600">You have no expired coupons.</p>
        @else
            <table class="min-w-full bg-white mt-4">
                <thead class="bg-gray-600 text-white">
                    <tr>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Code</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Discount</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Expiry Date</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Type</th>
                        <th class="w-1/5 px-2 py-2 sm:px-4 sm:py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($expiredCoupons as $coupon)
                        <tr>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ $coupon->code }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                @if(is_null($coupon->discount))
                                    N/A
                                @else
                                    {{ $coupon->discount }}%
                                @endif
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}</td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                            @switch($coupon->type)
                                @case('free_delivery')
                                    Free Delivery
                                    @break
                                @default
                                    {{ ucfirst($coupon->type) }}
                            @endswitch
                            </td>
                            <td class="border px-2 py-2 sm:px-4 sm:py-2">
                                <span class="text-red-500">Expired</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endif
@endsection
</x-app-layout>
