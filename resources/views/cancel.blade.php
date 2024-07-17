<x-app-layout>
@section('content')
    <div class="py-4 pb-2">
        <div class="mx-auto">
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none px-4 sm:px-8 flex flex-wrap">
                    <li class="flex items-center">
                        @if(session('previous_page') == 'orderhis')
                            <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard&nbsp;&nbsp;</a>
                        @else
                            <a href="/" class="text-gray-700 hover:text-gray-900">Home&nbsp;&nbsp;</a>
                        @endif
                        <i class="fa-solid fa-angle-right text-gray-500"></i>
                    </li>
                    <li class="flex items-center">
                        @if(session('previous_page') == 'orderhis')
                            <a href="/orders" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Order History&nbsp;&nbsp;</a>
                        @else
                            <a href="/cart" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Shopping Cart&nbsp;&nbsp;</a>
                        @endif
                        <i class="fa-solid fa-angle-right text-gray-500"></i>
                    </li>
                    <li class="flex items-center">
                        @if(session('previous_page') == 'orderhis')
                            <span class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Order Details for #{{ $order->id }}</span>
                        @else
                            <span class="text-gray-700">&nbsp;&nbsp;Checkout&nbsp;&nbsp;</span>
                            <i class="fa-solid fa-angle-right text-gray-500"></i>
                            <span class="text-gray-700">&nbsp;&nbsp;Order Cancelled</span>
                        @endif
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="text-center pt-2">
        <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
            {{ __('Order Cancelled') }}
        </h1>
    </div>
    <div class="mx-10 md:mx-24 my-8 p-7 bg-white rounded-lg shadow-md">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="red" class="bi bi-x-circle inline-block align-middle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            <h2 class="mt-3 text-lg sm:text-2xl font-semibold text-gray-700">Sorry, your order has been cancelled.</h2>
            <p class="mt-2 text-gray-600">Unfortunately, your order could not be completed. Please try placing your order again.</p>
        </div>
        <div class="px-4 mt-7 grid gap-4 sm:grid-cols-1 md:grid-cols-2">
            <div class="mt-1">
                <h3 class="text-lg font-medium text-gray-900">Cancelled Order Summary</h3>
                <ul class="mt-2 text-gray-600">
                    <li>Order Number: <strong>#{{ $order->id }}</strong></li>
                    <li>Order Date: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                    <li>Status: <strong>{{ ucfirst($order->status) }}</strong></li>
                    <li>Recipient: <strong>{{ $order->recipient_name }}</strong></li>
                    <li>Contact: <strong>{{ $order->recphone }}</strong></li>
                    <li>Deal Method: <strong>{{ ucfirst($order->delmethod) }}</strong></li>
                    <li class="w-64 sm:w-64 py-3">Delivery Address: <br><strong>{{ $order->street }}, {{ $order->postcode }} {{ $order->city }}, {{ $order->state }}.</strong></li>
                    <li class="w-64 sm:w-64 pb-3">Billing Address: <br><strong>{{ $order->billaddress }}</strong></li>
                    <li>Total Amount: <strong>RM {{ number_format($order->pricebefdis, 2) }}</strong></li>
                    <li>Delivery Fee: <strong>RM {{ number_format($order->deliveryfee, 2) }}</strong></li>
                    <li>Discounted Amount: <strong>RM 
                        @if(empty($order->discount))
                            0.00
                        @else
                            {{ number_format($order->discount, 2) }}
                        @endif
                    </strong></li>
                    <li>Promo Code Used: <strong>
                        @if(empty($order->promocode))
                            N/A
                        @else
                            {{ $order->promocode }}
                        @endif
                    </strong></li>
                    <li>Total Amount Paid: <strong>RM {{ number_format($order->newprice, 2) }}</strong></li>
                </ul>
            </div>
            <div class="mt-1 mb-2">
                <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
                @foreach($order->cakes as $cake)
                <ul class="mt-2 text-gray-600">
                    <li>Cake Name: <strong>{{ $cake->name }}</strong></li>
                    <li>Quantity: <strong>{{ $cake->pivot->quantity }}</strong></li>
                    <li>Delivery Date & Time: <strong>{{ $cake->pivot->deldate }} &nbsp;|&nbsp; {{ $cake->pivot->deltime }}</strong></li>
                    <li>Big & Small Candles: <strong>{{ $cake->pivot->bcandle }} &nbsp;|&nbsp; {{ $cake->pivot->scandle }}</strong></li>
                    <li>Gift Message: <strong>{{ $cake->pivot->message }}</strong></li>
                </ul>
                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                @endforeach
            </div>
        </div>


        <div class="flex flex-col md:flex-row justify-end items-center">
            <h4 class="text-3xl text-amber-500 leading-tight">Unfortunately, you have no points for this order. <p class="font-light text-sm sm:text-lg text-gray-800 leading-tight pt-1">Earn loyalty points and redeem rewards when you spend on our platform!<br><a href="{{ route('loyalty.page') }}" class="text-decoration-none text-dark text-sm font-semibold">Click here to learn more about the rewards program.</a></p></h4>
            <a href="{{ route('orders.list') }}" class="text-decoration-none text-dark hidden md:block">
                <img src="/img/ordercancelicon.png" class="w-32 h-32 md:w-auto md:h-64">
            </a>
        </div>
        
        <div class="mt-16 mb-2 text-center space-y-4 md:space-y-0 md:flex md:space-x-4">
            <a href="{{ route('orders.list') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 font-semibold text-white rounded-md">View Order History</a>
            <a href="/cart" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 font-semibold text-white rounded-md">View Cart Page</a>
            <button onclick="deleteOrder({{ $order->id }})" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700">Delete Order</button>
        </div>
    </div>

<script>
function deleteOrder(orderId) {
    fetch('/order/delete', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ orderId: orderId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to a different page or show a success message
            window.location.href = '/orders';
        } else {
            // Show an error message
            alert('Failed to delete the order.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

@endsection
</x-app-layout>
