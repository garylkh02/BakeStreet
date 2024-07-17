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
                @if(session('previous_page') == 'orderlist')
                <li class="flex items-center">
                    <a href="/bakery/orderlist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Order Management &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                @endif
                <li class="flex items-center">
                    <a href="/bakery/custom-orders" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Custom Orders</a>
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

<div class="container pb-16">
    <div class="text-center pt-10 pb-6">
        <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
            {{ __('Custom Orders') }}
        </h1>
    </div>

    @if($customOrders->isEmpty())
    <div class="text-center py-4">
        <p class="text-xl text-gray-600">Opps! There is no order yet.. &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
    </div>
    @else
    <ul class="list-group">
        @foreach($customOrders as $order)
            <li class="list-group-item flex items-center justify-between">
                <a href="{{ route('bakery.custom.show', $order->id) }}" class="text-lg md:text-xl text-gray-900 font-semibold hover:text-orange-500 flex justify-between w-full">
                    <span>Customised Cake #{{ $order->id }} - {{ $order->created_at->format('d M Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-blue-700 font-light"><i class="fa-solid fa-bars-progress"></i> {{ ucfirst($order->status) }}</span></span>
                    <span class="text-lg md:text-xl font-semibold text-gray-900 hover:text-orange-500">RM {{ number_format($order->price, 2) }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection
