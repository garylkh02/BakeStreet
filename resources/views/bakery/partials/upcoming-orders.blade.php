@extends('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/bakery/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/orderlist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Order Management &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/orders/upcoming" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Upcoming Orders</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="space-x-8 sm:-my-px sm:ms-10 mt-5 mb-4 hidden lg:flex sm:items-center">
    @if (Auth::user()->usertype == 'bakery')
        <x-nav-link href="{{ route('bakery.orders.pending') }}" :active="request()->routeIs('bakery.orders.pending')" class="hover:text-orange-500 active:text-amber-400">
        <i class="fa-solid fa-fire-burner fa-lg" style="color: #232323;"></i>&nbsp;&nbsp;{{ __('Preparing') }}
        </x-nav-link>

        <x-nav-link href="{{ route('bakery.orders.ready') }}" :active="request()->routeIs('bakery.orders.ready')" class="hover:text-orange-500 active:text-amber-400">
        <i class="fa-regular fa-circle-check fa-lg" style="color: #232323;"></i>&nbsp;&nbsp;{{ __('Ready') }}
        </x-nav-link> 

        <x-nav-link href="{{ route('bakery.orders.upcoming') }}" :active="request()->routeIs('bakery.orders.upcoming')" class="text-orange-500 hover:text-orange-300 active:text-amber-400 border-b-4 border-orange-500 hover:border-b-4 hover:border-amber-400 active:border-b-4 active:border-red-500 pb-3 text-xl">
        <i class="fa-regular fa-calendar-days fa-lg" style="color: #232323;"></i>&nbsp;&nbsp;{{ __('Upcoming') }}
        </x-nav-link> 

        <x-nav-link href="{{ route('bakery.orders.completed') }}" :active="request()->routeIs('bakery.orders.completed')" class="hover:text-orange-500 active:text-amber-400">
        <i class="fa-solid fa-clock fa-lg" style="color: #232323;"></i>&nbsp;&nbsp;{{ __('History') }}
        </x-nav-link> 

        <!-- Search Bar -->
        <div class="searchbar hidden lg:flex sm:items-center sm:ms-6">
        <form action="{{ route('bakery.orders.search') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search by order id" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
        </form>
        </div>
    @endif
</div>

<h1 class="text-left pt-6 pl-11 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Upcoming Orders') }}
</h1>
<div class="container">
    @if($upcomingOrders->isEmpty())
        <div class="text-center py-4">
            <p class="text-2xl text-gray-600 mt-5">Opps! It's empty here! &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
        </div>
    @else
    <ul class="w-full px-12 pt-4">
    @foreach($upcomingOrders as $order)
        @php
            $deliveryDate = new DateTime($order->deldate);
            $currentDate = new DateTime();
            $interval = $currentDate->diff($deliveryDate);
            $daysLeft = $interval->days;
        @endphp
        <li>
            <a href="{{ route('bakery.orders.show', $order->id) }}" class="inline-flex items-center justify-between w-full p-4 py-3 text-gray-900 bg-amber-400 border-2 border-amber-400 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
                <div class="block">
                <br>
                    <div class="w-full text-xl font-bold text-black text-left">Order Number: #{{ $order->id }}</div>
                   
                    <div class="w-full text-xl text-left pt-1">{{ $order->quantity }}x {{ $order->name }}</div>
                    <div class="w-full text-md text-left pt-1">Cake Price: RM {{ number_format($order->price, 2) }}</div>
                    <div class="w-full text-md text-left pt-1">Status: {{ ucfirst($order->status) }}</div>
                    <div class="w-full text-sm text-left pt-1">Preparation time remaining: {{ $daysLeft }} Days</div>
                </div>
                
                    <img src="{{ asset($order->photo) }}" alt="Cake Image" class="w-40 h-40 object-cover rounded-xl">
            </a>
        </li>
        <br>
        @endforeach
    </ul>
    @endif
</div>

<br>
<br>
<script>
    // Refresh the page every 10 minutes (600,000 milliseconds)
    setTimeout(function() {
        window.location.reload();
    }, 300000); // 600000 ms = 10 minutes
</script>
@endsection

