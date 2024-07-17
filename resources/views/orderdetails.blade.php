<x-app-layout>
@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex flex-wrap">
                <li class="flex items-center">
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard&nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                    <a href="{{ route('orders.list') }}" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Order History&nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right text-gray-500"></i>
                    <span class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Order Details for #{{ $order->id }}</span>
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
        {{ __('Order Details') }}
    </h1>
</div>
<div class="mx-10 md:mx-24 my-8 p-4 md:p-7 bg-white rounded-lg shadow-md">
    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="green" class="bi bi-check-circle inline-block align-middle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </svg>
        <h2 class="mt-3 text-2xl font-semibold text-gray-700">Order Summary for #{{ $order->id }}</h2>
    </div>
    <div class="px-2 md:px-4 mt-7 grid gap-4 sm:grid-cols-1 md:grid-cols-2">
        <div class="mt-1">
            <h3 class="text-2xl font-semibold text-gray-900">Order Summary</h3>
            <ul class="mt-2 text-gray-600 text-lg">
                <li>Order Number: <strong>#{{ $order->id }}</strong></li>
                <li>Order Date: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                <li>Status: <strong>{{ ucfirst($order->status) }}</strong></li>
                <li>Recipient: <strong>{{ $order->recipient_name }}</strong></li>
                <li>Contact: <strong>{{ $order->recphone }}</strong></li>
                <li>Deal Method: <strong>{{ ucfirst($order->delmethod) }}</strong></li>
                <li class="py-3">Delivery Instructions: <br><strong>{{ ucfirst($order->delivery_instructions) }}</strong></li>
                <li class="py-3">Delivery Address: <br><strong>{{ $order->street }}, {{ $order->postcode }} {{ $order->city }}, {{ $order->state }}.</strong></li>
                <li class="pb-3">Billing Address: <br><strong>{{ $order->billaddress }}</strong></li>
            </ul>
        </div>
        <div class="mt-1">
            <h3 class="text-2xl font-semibold text-gray-900">Order Information</h3>
            @foreach($order->cakes as $cake)
            <ul class="mt-2 text-gray-600">
                <li>Cake Ordered: <strong>{{ $cake->name }}</strong></li>
                <li>Cake Size: <strong>{{ $cake->pivot->size }}</strong></li>
                <li>Quantity: <strong>{{ $cake->pivot->quantity }}</strong></li>
                <li>Delivery Date & Time: <strong>{{ $cake->pivot->deldate }} | {{ $cake->pivot->deltime }}</strong></li>
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
                    <div class="addons flex flex-wrap">
                        <li>Add-Ons:</li>
                        @foreach($selectedAddons as $addonKey => $addonValue)
                            <strong>&nbsp;{{ ucfirst($addonKey) }}</strong>
                        @endforeach
                    </div>
                    @else
                    <strong>No add-ons selected.</strong>
                    @endif
                @endif
                <!-- Other cake details -->
                @if ($order->status == 'completed')
                <li class="pt-2 pb-3">
                    <a href="#" class="text-lg md:text-xl font-bold text-amber-500 hover:text-orange-500 underline hover:no-underline" data-toggle="modal" data-target="#reviewModal{{$cake->id}}">
                        <i class="fa-solid fa-star"></i> Spill the tea on this cake! [Rate your experience]
                    </a>
                </li>
               
                <!-- Modal -->
                <div class="modal fade" id="reviewModal{{$cake->id}}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel{{$cake->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-orange-500 font-semibold" id="reviewModalLabel{{$cake->id}}">{{ $cake->name }} <i class="fa-regular fa-comment"></i></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $review = $reviews->get($cake->id);
                                @endphp
                                @include('create_edit', ['review' => $review, 'cakeId' => $cake->id, 'orderId' => $order->id])
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </ul>
            <div class="border-t border-gray-300 pb-2"></div>
            @endforeach
        </div>
    </div>
    <ul class="mt-2 text-lg md:text-xl text-gray-600 mr-2 md:mr-4">
        <li class="flex justify-between py-1">Subtotal: <strong>RM {{ number_format($subtotal, 2) }}</strong></li>
        <li class="flex justify-between py-1">Service Tax: <strong>RM {{ number_format($serviceTax, 2) }}</strong></li>
        <li class="flex justify-between py-1">Total Amount: <strong>RM {{ number_format($totalPrice, 2) }}</strong></li>
        <li class="flex justify-between py-1">Delivery Fee: <strong>RM {{ number_format($order->deliveryfee, 2) }}</strong></li>
        <li class="flex justify-between py-1">Discounted Amount: <strong>RM 
            @if(empty($order->discount))
                0.00
            @else
                {{ number_format($order->discount, 2) }}
            @endif
        </strong></li>
        <li class="flex justify-between py-1">Promo Code Used: <strong>
            @if(empty($order->promocode))
                N/A
            @else
                {{ $order->promocode }}
            @endif
        </strong></li>
    </ul>
    <div class="border-t border-gray-400 dark:border-gray-400"></div>
    <ul class="mt-2 text-xl text-gray-600 mr-2 md:mr-4">
        <li class="text-lg lg:text-2xl flex justify-between py-1"><b>Total Amount Paid:</b><strong>RM {{ number_format($order->newprice, 2) }}</strong></li>
        <br>
    </ul>
    <div class="flex justify-end items-center pl-6">
        <h4 class="text-3xl text-amber-500 leading-tight">Congratulations! You've earned {{ floor($order->newprice) }} points! <p class="font-light text-lg text-gray-800 leading-tight pt-1">Earn loyalty points and redeem rewards when you spend on our platform!<br><a href="{{ route('loyalty.page') }}" class="text-decoration-none text-gray-900 hover:text-orange-500 text-sm font-semibold">Click here to learn more about the rewards program.</a></p></h4>
        <a href="{{ route('loyalty.page') }}" class="text-decoration-none text-dark hidden md:block">
            <img src="/img/pointearnedicon.png" class="w-auto h-80">
        </a>
    </div>
    <div class="mt-14 mb-2 text-center">
        <a href="{{ route('orders.list') }}" class="px-4 py-2 bg-orange-500 hover:bg-amber-500 text-white rounded-md">Back to Orders</a>
    </div>
</div>
<br>
<br>
<!-- CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
</x-app-layout>
