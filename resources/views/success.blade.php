<x-app-layout>
    @section('content')

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-4 sm:px-8 flex flex-wrap">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home&nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                </li>
                <li class="flex items-center">
                    <a href="/cart" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Shopping Cart&nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-700">&nbsp;&nbsp;Checkout&nbsp;&nbsp;</span>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-700">&nbsp;&nbsp;Payment&nbsp;&nbsp;</span>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-700">&nbsp;&nbsp;Order Success</span>
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

    <div class="text-center pt-2">
        <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
            {{ __('Order Successful') }}
        </h1>
    </div>

    <div class="mx-10 md:mx-20 my-8 p-7 px-16 bg-white rounded-lg shadow-md">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="green" class="bi bi-check-circle inline-block align-middle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
            </svg>
            <h2 class="mt-3 text-2xl font-semibold text-gray-700">Thank you for your order!</h2>
            <p class="mt-2 text-gray-600">Your order has been placed successfully. We will send you an email confirmation shortly.</p>
        </div>

        <div class="mt-7 grid gap-4 grid-cols-1 md:grid-cols-2">
            <div class="mt-1">
                <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                <ul class="mt-2 text-gray-600">
                    <li>Order Number: <strong>#{{ $order->id }}</strong></li>
                    <li>Order Date: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                    <li>Status: <strong>{{ ucfirst($order->status) }}</strong></li>
                    <li>Recipient: <strong>{{ $order->recipient_name }}</strong></li>
                    <li>Contact: <strong>{{ $order->recphone }}</strong></li>
                    <li>Deal Method: <strong>{{ ucfirst($order->delmethod) }}</strong></li>
                    <li class="w-96 py-3">Delivery Instructions: <br><strong>{{ ucfirst($order->delivery_instructions) }}</strong></li>
                    <li class="w-64 py-3">Delivery Address: <br><strong>{{ $order->street }}, {{ $order->postcode }} {{ $order->city }}, {{ $order->state }}.</strong></li>
                    <li class="w-64 pb-3">Billing Address: <br><strong>{{ $order->billaddress }}</strong></li>
                    <li class="text-2xl">Total Amount Paid: <strong>RM {{ number_format($order->newprice, 2) }}</strong></li>
                </ul>
            </div>
            <div class="mt-1 mb-2">
                <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
                @foreach($order->cakes as $cake)
                <ul class="mt-2 text-gray-600">
                    <li>Cake Name: <strong>{{ $cake->name }}</strong></li>
                    <li>Cake Size: <strong>{{ $cake->pivot->size }}</strong></li>
                    <li>Quantity: <strong>{{ $cake->pivot->quantity }}</strong></li>
                    <li>Delivery Date & Time: <strong>{{ $cake->pivot->deldate }} &nbsp;|&nbsp; {{ $cake->pivot->deltime }}</strong></li>
                    <li>Big & Small Candles: <strong>{{ $cake->pivot->bcandle }} &nbsp;|&nbsp; {{ $cake->pivot->scandle }}</strong></li>
                    <li>Gift Message: 
                    @if($cake->pivot->message)
                    <strong>{{ $cake->pivot->message }}</strong>
                    @else
                    <strong>No Gift Message</strong>
                    @endif
                    </li>
                    @if($cake->pivot->addons)
                        @php
                            $selectedAddons = json_decode($cake->pivot->addons, true);
                        @endphp
                    @if($selectedAddons)
                    <div class="addons flex">
                        <li>Add-Ons:</li>
                            @foreach($selectedAddons as $addonKey => $addonValue)
                            <strong>&nbsp;{{ ucfirst($addonKey) }}</strong>
                            @endforeach
                    </div>
                    @else
                    <strong>No add-ons selected.</strong>
                    @endif
                    @endif
                </ul>
                <div class="border-t border-gray-300 pb-2"></div>
                @endforeach
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-end items-center">
            <h4 class="text-3xl text-amber-500 leading-tight">Congratulations! You've earned {{ floor($order->newprice) }} points! 
                <p class="font-light text-lg text-gray-800 leading-tight pt-1">Earn loyalty points and redeem rewards when you spend on our platform!<br>
                <a href="{{ route('loyalty.page') }}" class="text-decoration-none text-gray-900 hover:text-orange-500 text-sm font-semibold">Click here to learn more about the rewards program.</a>
                </p>
            </h4>
            <a href="{{ route('loyalty.page') }}" class="text-decoration-none text-dark hidden md:block">
                <img src="/img/pointearnedicon.png" class="w-32 h-32 md:w-auto md:h-80">
            </a>
        </div>
        
        <div class="mt-16 mb-2 text-center">
        <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4 justify-center">
            <a href="/" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-amber-500">Go to Homepage</a>
            <a href="/orders/{{ $order->id }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-600 text-white rounded-md">View Order Details</a>
        </div>
</div>

    </div>
    @endsection
</x-app-layout>
