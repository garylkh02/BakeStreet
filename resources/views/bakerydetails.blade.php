@extends('layouts.app')

@section('content')
<div class="banner">
    <img src="/img/bakerydetailcover.svg" class="banner-image w-full" alt="Banner Image">
    <div class="banner-name text-4xl sm:text-5xl md:text-6xl text-center">
        {{ $bakery->name }}
    </div>
    <div class="banner-earnings text-2xl sm:text-3xl md:text-4xl mt-2">
        {{ __('Overall Rating:') }}<br><i class="fa-solid fa-star" style="color: #ffaa00;"></i> {{ number_format($averageRating, 2) }}
    </div>
</div>

<div class="py-4 pb-0">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-4 sm:px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakeries" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Shop by Bakery &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakeries.profile', $bakery->id) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $bakery->name }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-left pt-4 font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
        {{ $bakery->name }}
    </h1>

    <p class="text-md sm:text-lg md:text-xl mb-2">Address: {{ $bakery->user->address }}</p>
    <p class="text-md sm:text-lg md:text-xl">Location: {{ $bakery->location }}</p>

    <h1 class="block mb-3 font-bold text-2xl sm:text-3xl text-gray-900 pl-1 pt-8">Products</h1>
    @if ($bakery->cakes->isEmpty())
        <p class="text-center text-lg sm:text-xl pt-6">This bakery has no product yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            @foreach($bakery->cakes as $cake)
                <div class="shadow-md rounded-lg bg-gray-50 block hover:bg-gray-100 transition-colors">
                    <a href="/allproducts/{{ $cake->id }}">
                        <img src="{{ asset($cake->photo) }}" alt="{{ $cake->name }}" class="w-full h-52 object-cover rounded-t-md">
                    </a>
                    <div class="p-4">
                        <div class="flex justify-between">
                            <a href="/allproducts/{{ $cake->id }}" class="text-md sm:text-lg font-semibold text-gray-900 hover:text-orange-500">{{ $cake->name }}</a>
                            @if($cake->original_price && $cake->price < $cake->original_price)
                                <div class="flex pt-1">
                                    <p class="text-md font-semibold text-gray-900 hover:text-orange-500">
                                        <span style="text-decoration: line-through;">RM {{ $cake->original_price }}</span>
                                    </p>
                                    &nbsp;&nbsp;
                                    <p class="text-md font-semibold text-gray-900 hover:text-orange-500">
                                        <span style="color: red;">RM {{ $cake->price }}</span>
                                    </p>
                                </div>
                            @else
                                <p class="text-md sm:text-lg font-semibold text-gray-900 hover:text-orange-500">RM {{ $cake->price }}</p>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm sm:text-md text-gray-500 mb-1">Category: {{ $cake->category->name }}</p>
                            <p class="text-sm sm:text-md text-gray-500 mb-1">
                                <i class="fa-solid fa-star" style="color: #ffaa00;"></i> 
                                {{ number_format($cake->averageRating, 1) }} ({{ $cake->reviewCount }})
                            </p>
                        </div>
                        <p class="text-sm sm:text-md text-gray-500 mb-0">Flavour: {{ $cake->flavour->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h1 class="block mb-3 font-bold text-2xl sm:text-3xl text-gray-900 pl-1 pt-16">Some reviews given by customers</h1>
    @if ($randomReviews->isEmpty())
        <p class="text-center text-lg sm:text-xl pt-6 pb-16">Opps! No review has been given.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-14">
            @foreach($randomReviews as $review)
                <div class="flex items-center px-4 shadow-md rounded-lg bg-gray-50 block hover:bg-gray-100 transition-colors">
                    <img src="{{ asset($review->cake->photo) }}" alt="{{ $review->cake->name }}" class="w-24 h-24 object-cover rounded-md">
                    <div class="ml-5">
                        <p class="text-md sm:text-lg font-semibold text-gray-900 hover:text-orange-500 mb-0 mt-3">{{ $review->cake->name }}</p>
                        <p class="text-sm text-gray-500 mt-0 mb-1">{{ $review->review }}</p>
                        <p class="text-sm text-gray-500 mt-0">
                            <i class="fa-solid fa-star" style="color: #ffaa00;"></i> 
                            {{ number_format($review->rating, 1) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
