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
                    <a href="/bakery/orderlist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Order Management &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/custom-orders" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Custom Orders &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.custom.show', $customOrder->id) }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Custom Order Details for #{{ $customOrder->id }}</a>
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
    <h1 class="text-3xl md:text-4xl font-semibold text-gray-800 leading-tight">
        {{ __('Custom Order Details') }}
    </h1>
</div>

<div class="mx-10 md:mx-24 my-8 p-7 pb-0 bg-white rounded-lg shadow-md">
    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="green" class="bi bi-check-circle inline-block align-middle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </svg>
        <h2 class="mt-3 text-2xl font-semibold text-gray-700">Custom Order Summary for #{{ $customOrder->id }}</h2>
    </div>

    <div class="mt-6 grid w-full gap-4 md:grid-cols-3">
        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
            <ul class="mt-2 text-gray-600">
                <li>Order Number: <strong>#{{ $customOrder->id }}</strong></li>
                <li>Order Date: <strong>{{ $customOrder->created_at->format('d M Y, H:i') }}</strong></li>
                <li>Pick-Up Date: <strong>{{ $customOrder->deldate }}</strong></li>
                <li>Pick-Up Time: <strong>{{ $customOrder->deltime }}</strong></li>
                <li>Total Amount Paid: <strong>RM {{ number_format($totalPrice, 2) }}</strong></li>
            </ul>
        </div>
        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Customer Details</h3>
            <ul class="mt-2 text-gray-600">
                <li>Name: <strong>{{ $customOrder->name }}</strong></li>
                <li>Email Address: <strong>{{ $customOrder->email }}</strong></li>
                <li>Contact: <strong>{{ $customOrder->phone }}</strong></li>
                <li class="py-3">Billing Address: <strong>{{ $customOrder->billaddress }}</strong></li>
            </ul>
        </div>
        <div class="mt-1">
            <h3 class="text-lg font-medium text-gray-900">Customisation Details</h3>
            <ul class="mt-2 text-gray-600">
                <li>Cake Type: <strong>{{ $customOrder->category->name }}</strong></li>
                <li>Cake Size: <strong>{{ $customOrder->size }}</strong></li>
                <li>Flavour: <strong>{{ $customOrder->flavours->name }}</strong></li>
                <li>Topping: <strong>{{ $customOrder->toppings->name }}</strong></li>
                <li>Message on Cake: <strong>{{ $customOrder->message_on_cake }}</strong></li>
                <li>Price (inc. VAT): <strong>RM {{ number_format($customOrder->price, 2) }}</strong></li>
                <li>Quantity: <strong>{{ $customOrder->quantity }}</strong></li>
                <li>Big & Small Candle: <strong>{{ $customOrder->bcandle }} | {{ $customOrder->scandle }}</strong></li>
                <li>Card Message: <strong>{{ $customOrder->message }}</strong></li>
            </ul>
        </div>
    </div>

    <!-- Display the uploaded image -->
    <div class="mt-6 text-center">
        <h3 class="text-lg font-medium text-gray-900">Uploaded Cake Photo</h3>
        @if ($customOrder->photo)
            <img src="{{ asset($customOrder->photo) }}" alt="Cake Photo" class="mx-auto mt-4 w-64 h-auto rounded-lg shadow-md">
        @else
            <p>No photo uploaded.</p>
        @endif
    </div>
   
    <div class="mt-14 mb-2 text-center">
        <form action="{{ route('bakery.customOrders.updateStatus', $customOrder->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="status" class="block text-xl font-bold text-gray-700">Update Order Status</label>
                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md rounded-md">
                    <option value="pending" {{ $customOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ready" {{ $customOrder->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $customOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md"><i class="fa-solid fa-floppy-disk"></i> &nbsp;Update Status</button>
            </div>
        </form>
    </div>
    
    <div class="container mx-auto my-4 text-center">
        <a href="{{ route('bakery.custom.orders') }}" class="px-6 py-2 mb-4 bg-amber-400 hover:bg-orange-500 font-bold text-white rounded-md"><i class="fa-solid fa-chevron-left"></i> &nbsp;Back</a>
    </div>
    <br>
</div>
@endsection
