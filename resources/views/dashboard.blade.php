<x-app-layout>
@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
@endif
<div class="banner">
<img src="/img/userdas.svg" class="banner-image" alt="Banner Image">
    <div class="banner-name text-4xl sm:text-5xl md:text-6xl">
        Welcome back, {{ $user->name }}
    </div>
    <div class="banner-earnings text-4xl">
        {{ __('Current Points:') }}<br> {{ $currentPoints }}
    </div>
</div>

<h1 class="text-center pt-6 font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
    {{ __("$pendingOrdersCount pending orders") }} &nbsp;&nbsp; {{ __('|') }} &nbsp;&nbsp; {{ __("$completedOrdersCount completed orders") }}
</h1>

<div class="container text-center mt-20 mb-20">
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('orders.list') }}" class="text-decoration-none text-dark">
                <img src="/img/ordericon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Orders</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('loyalty.page') }}" class="text-decoration-none text-dark">
                <img src="/img/membericon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Loyalty Program</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href=" {{ route('coupons') }}" class="text-decoration-none text-dark">
                <img src="/img/couponicon.png">
                <div class="flex items-center justify-center">
                    @if($availableCoupons)
                        <i class="fa-solid fa-circle fa-bounce" style="color: #ff2600;"></i>
                    @endif
                    <h4 class="font-bold text-3xl text-gray-800 leading-tight ml-2">Coupons</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('reviews') }}" class="text-decoration-none text-dark">
                <img src="/img/userrateicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Feedback</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('fav.list') }}" class="text-decoration-none text-dark">
                <img src="/img/favicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Favourite Cakes</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark">
                <img src="/img/settingicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Settings</h4>
            </a>
        </div>
    </div>
</div>
<script>
    // Refresh the page every 10 minutes (600,000 milliseconds)
    setTimeout(function() {
        window.location.reload();
    }, 300000); // 600000 ms = 10 minutes
</script>
@endsection

</x-app-layout>
