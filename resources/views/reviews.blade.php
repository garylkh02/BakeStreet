@extends('layouts.app')

@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/reviews" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Feedback</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="text-center pt-2 pb-3">
    <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
        {{ __('Your Reviews') }}
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

<div class="container">
    @if ($reviews->isEmpty())
        <p class="text-center text-xl">You have not reviewed any cakes yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID <i class="fa-solid fa-paperclip" style="color: #ffaa00;"></i></th>
                    <th>Cake Name <i class="fa-solid fa-cake-candles" style="color: #ffaa00;"></i></th>
                    <th>Bakery Name <i class="fa-solid fa-shop" style="color: #ffaa00;"></i></th>
                    <th>Review <i class="fa-solid fa-comment" style="color: #ffaa00;"></i></th>
                    <th>Rating <i class="fa-solid fa-star" style="color: #ffaa00;"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>
                        <a href="{{ route('orders.show', $review->order_id) }}" class="text-gray-900 hover:text-orange-500"># {{ $review->order_id }}</a>
                        </td>
                        <td>
                        <a href="/allproducts/{{ $review->cake->id }}" class="text-gray-900 hover:text-orange-500">{{ $review->cake->name }}</a>
                        </td>
                        <td>{{ $review->cake->bakery->name }}</td>
                        <td>{{ $review->review }}</td>
                        <td>{{ $review->rating }} / 5</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <br>
    <br>
    <br>
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="sm:w-1/2">
            <h4 class="text-2xl sm:text-3xl text-amber-500 leading-tight">Haven't reviewed your recent order? Earn points!</h4>
            <p class="font-light text-lg sm:text-xl text-gray-800 leading-tight pt-1">
                Every review you write earns you up to 10 points to redeem for exciting rewards!<br>
                <a href="{{ route('orders.list') }}" class="text-decoration-none text-gray-900 hover:text-orange-500 text-sm font-semibold">View your order now and share your thoughts on the taste, texture, and overall experience.</a>
            </p>
        </div>
        <a href="{{ route('orders.list') }}" class="text-decoration-none text-dark">
            <img src="/img/reviewcov.png" class="w-full sm:w-auto h-60 sm:h-80">
        </a>
    </div>
    
    <br>
    <br>
</div>
@endsection
