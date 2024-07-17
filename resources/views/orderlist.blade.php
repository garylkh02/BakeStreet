<x-app-layout>
    @section('content')
    <div class="py-4 pb-2">
        <div class="mx-auto">
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none px-8 inline-flex">
                    <li class="flex items-center">
                        <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard &nbsp&nbsp</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                        <a href="/orders" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Order History</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="text-center pt-2 pb-3">
        <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
            {{ __('Order History') }}
        </h1>
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
        @if($remainingOrders->isEmpty())
            <div class="text-center py-4">
                <p class="text-lg md:text-xl text-gray-600">Opps! You have no orders yet.. &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
            </div>
            <div class="mt-4 mb-2 text-center">
            <a href="/allproducts" class="px-4 py-3 bg-orange-500 hover:bg-amber-500 text-white text-lg md:text-xl font-bold rounded-md"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i> &nbsp;Browse Our Cakes Here!</a>
            </div>
        @else
            <ul class="list-group">
                @foreach($remainingOrders as $remainingOrder)
                    @php
                        $subtotal = $remainingOrder->cakes->sum(function($cake) {
                            return $cake->pivot->price * $cake->pivot->quantity;
                        });
                        $serviceTax = $subtotal * 0.06;
                        $totalPrice = $subtotal + $serviceTax;
                    @endphp
                    <li class="list-group-item flex items-center justify-between">
                        <a href="{{ route('orders.show', $remainingOrder->id) }}" class="text-lg md:text-xl text-gray-900 font-semibold hover:text-orange-500 flex justify-between w-full">
                            <span>Order #{{ $remainingOrder->id }} - {{ $remainingOrder->created_at->format('d M Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-blue-700 font-light"><i class="fa-solid fa-bars-progress"></i> {{ ucfirst($remainingOrder->status) }}</span></span>
                            <span class="text-lg md:text-xl font-semibold text-gray-900 hover:text-orange-500">RM {{ number_format($remainingOrder->newprice, 2) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    @endsection
</x-app-layout>
