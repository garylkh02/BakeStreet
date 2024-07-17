@extends('layouts.bakery')
@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap space-x-2">
                <li class="flex items-center">
                    <a href="/bakery/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/orderlist" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Order Management &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'pending')
                        <a href="{{ route('bakery.orders.pending') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Pending Orders &nbsp;&nbsp;</a>
                    @elseif(session('previous_page') == 'ready')
                        <a href="{{ route('bakery.orders.ready') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Ready Orders &nbsp;&nbsp;</a>
                    @elseif(session('previous_page') == 'upcoming')
                        <a href="{{ route('bakery.orders.upcoming') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Upcoming Orders &nbsp;&nbsp;</a>
                    @elseif(session('previous_page') == 'completed')
                        <a href="{{ route('bakery.orders.completed') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Completed Orders &nbsp;&nbsp;</a> 
                    @endif
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.orders.show', $order->id) }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Order Details for #{{ $order->id }}</a>
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

<div class="text-center pt-5">
    <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
        {{ __('Order Details') }}
    </h1>
</div>
<div class="mx-10 my-8 p-4 sm:p-7 pb-0 bg-white rounded-lg shadow-md">
    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="green" class="bi bi-check-circle inline-block align-middle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </svg>
        <h2 class="mt-3 text-2xl font-semibold text-gray-700">Order Summary for #{{ $order->id }}</h2>
    </div>
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
            <ul class="mt-2 text-gray-600">
                <li>Order Number: <strong>#{{ $order->id }}</strong></li>
                <li>Order Date: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                <li>Status: <strong>{{ ucfirst($order->status) }}</strong></li>
                <li>Subtotal: <strong>RM {{ number_format($subtotal, 2) }}</strong></li>
                <li>Service Tax: <strong>RM {{ number_format($serviceTax, 2) }}</strong></li>
                <li>Total Amount: <strong>RM {{ number_format($totalPrice, 2) }}</strong></li>
            </ul>
        </div>

        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Customer Details</h3>
            <ul class="mt-2 text-gray-600">
                <li>Recipient: <strong>{{ $order->recipient_name }}</strong></li>
                <li>Contact: <strong>{{ $order->recphone }}</strong></li>
                <li class="w-full sm:w-64 py-3">Delivery Address: <br><strong>{{ $order->street }}, {{ $order->postcode }} {{ $order->city }}, {{ $order->state }}.</strong></li>
                <li class="w-full sm:w-64 pb-3">Billing Address: <br><strong>{{ $order->billaddress }}</strong></li>
                <li>Deal Method: <strong>{{ ucfirst($order->delmethod) }}</strong></li>              
            </ul>
        </div>

        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
            @foreach($order->cakes as $cake)
            <ul class="mt-2 text-gray-600">
                <li>Cake Ordered: <strong>{{ $cake->name }}</strong></li>
                <li>Cake Price: <strong>RM {{ $cake->price }}</strong></li>
                <li>Quantity: <strong>{{ $cake->pivot->quantity }}</strong></li>
                <li>Total Cake Amount: <strong>RM {{ number_format($cake->price * $cake->pivot->quantity, 2) }}</strong></li>
                <li>Expected Completion Date & Time: <strong>{{ $cake->pivot->deldate }} | {{ $cake->pivot->deltime }}</strong></li>
                <li>Big & Small Candles: <strong>{{ $cake->pivot->bcandle }} &nbsp;|&nbsp; {{ $cake->pivot->scandle }}</strong></li>
                <li>Gift Message: <strong>{{ $cake->pivot->message }}</strong></li>
            </ul>
            <div class="border-t border-gray-400 mt-2"></div>
            @endforeach
        </div>
    </div>
   
    <div class="mt-14 mb-2 text-center">
        <form action="{{ route('bakery.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="status" class="block text-xl font-bold text-gray-700">Update Order Status</label>
                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md rounded-md">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md"><i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> &nbsp;Update Status</button>
            </div>
        </form>
    </div>
    
    <div class="container mx-auto my-4 text-center">
        <a href="{{ route('bakery.orders.pending') }}" class="px-14 py-2 mb-4 bg-amber-400 hover:bg-orange-500 font-bold text-white rounded-md"><i class="fa-solid fa-chevron-left" style="color: #ffffff;"></i> &nbsp;Back</a>
    </div>
    <br>
</div>
@endsection
