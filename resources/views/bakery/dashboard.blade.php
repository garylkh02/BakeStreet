@extends('layouts.bakery')
@section('content')

@if(session('success'))
    <div class="mb-0 p-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-0 p-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
@endif
<div class="banner">
    <video autoplay muted loop class="banner-video" style="top: 0; left: 0; z-index: -1; width: 100%; height: 100%;">
        <source src="/vid/bakeryvid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="banner-name text-4xl sm:text-5xl md:text-6xl">
        {{ $bakery->name }}
    </div>
    <div class="banner-earnings text-4xl">
        {{ __('Total sales this month:') }}<br>RM {{ number_format($totalAmountEarned, 2) }}
    </div>
</div>

<h1 class="text-center pt-10 font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
    {{ __("$pendingOrdersCount pending orders") }} &nbsp;&nbsp; {{ __('|') }} &nbsp;&nbsp; {{ __("$completedOrdersCount completed orders") }}
</h1>

<div class="container text-center mt-28 mb-20">
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('bakery.orderlist') }}" class="text-decoration-none text-dark">
                <img src="/img/ordericon.png">
                <div class="flex items-center justify-center">
                    @if($availablePending)
                        <i class="fa-solid fa-circle fa-bounce" style="color: #ff2600;"></i>
                    @endif
                    <h4 class="font-bold text-3xl text-gray-800 leading-tight ml-2">Orders</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('bakery.listproduct') }}" class="text-decoration-none text-dark">
                <img src="/img/menuicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Menu</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href=" {{ route('blog.create') }}" class="text-decoration-none text-dark">
                <img src="/img/blogicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Cake Blog</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('bakery.reviews') }}" class="text-decoration-none text-dark">
                <img src="/img/feedbackicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Feedback</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('bakerycontactus.create') }}" class="text-decoration-none text-dark">
                <img src="/img/helpicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Help Center</h4>
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
