@extends('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap">
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
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'ready')
                        <a href="{{ route('bakery.orders.ready') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Ready Orders &nbsp;&nbsp;</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'upcoming')
                        <a href="{{ route('bakery.orders.upcoming') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Upcoming Orders &nbsp;&nbsp;</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'completed')
                        <a href="{{ route('bakery.orders.completed') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Completed Orders &nbsp;&nbsp;</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @endif
                </li>
                <li class="flex items-center">
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Order Search Results</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-left pt-6 pb-3 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight">
        {{ __('Order Search Results') }}
    </h1>   
    <form action="{{ route('bakery.orders.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Order ID" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>

    @if($products->isEmpty())
        <div class="alert alert-warning" role="alert">
            No orders found.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Item Name</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Quantity</th>
                        <th class="border px-4 py-2">Delivery Date</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $totalAmount = $product->quantity * $product->price;
                        @endphp
                        <tr class="clickable-row" data-href="{{ route('bakery.orders.show', $product->id) }}">
                            <td class="border px-4 py-2">#{{ $product->id }}</td>
                            <td class="border px-4 py-2">{{ $product->created_at->format('d / m / Y') }}</td>
                            <td class="border px-4 py-2">{{ $product->name }}</td>
                            <td class="border px-4 py-2">RM {{ number_format($product->price, 2) }}</td>
                            <td class="border px-4 py-2">{{ $product->quantity }}</td>
                            <td class="border px-4 py-2">{{ $product->deldate }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($product->status) }}</td>
                            <td class="border px-4 py-2">RM {{ number_format($totalAmount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rows = document.querySelectorAll('.clickable-row');
        rows.forEach(function(row) {
            row.addEventListener('click', function() {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>
@endsection
