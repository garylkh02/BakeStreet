@extends('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap">
                <li class="flex items-center">
                    <a href="/bakery/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.listproduct') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; All Products &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.viewproduct', $cake->id) }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; {{ $cake->name }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="wrapper cake-details">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500 text-white rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if(session('mssg'))
        <div class="mb-4 p-4 bg-green-500 text-white rounded-md">
            {{ session('mssg') }}
        </div>
    @endif
    <br>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <img src="{{ asset($cake->photo) }}" class="w-full h-auto lg:w-96 lg:h-96 object-cover product-image" alt="Cake Photo">
        <div>
            <h1 class="font-bold text-xl lg:text-2xl">{{ $cake->name }}</h1>
            <p class="font-semibold text-lg text-orange-500">by {{ $cake->bakery->name }}</p>
            <p class="price text-lg lg:text-2xl mb-1">Current Selling Price: RM{{ $cake->price }}</p>
            <p class="price text-lg">Original Price: RM{{ $cake->original_price }}</p>
            <p class="flavour text-lg lg:text-xl">Flavour: {{ $cake->flavour->name }}</p>
            <p class="category text-lg lg:text-xl">Category: {{ $cake->category->name }}</p>
            <p class="description text-lg lg:text-xl">Description: {{ $cake->description }}</p>
            <p class="cakecare text-lg lg:text-xl">Cake Care Instructions: {{ $cake->cakecare }}</p>
            <p class="ingredients text-lg lg:text-xl">Cake Ingredients: {{ $cake->ingredients }}</p>
            <p class="allergens text-lg lg:text-xl">Allergens: {{ $cake->allergens }}</p>
            <p class="items text-lg lg:text-xl">What's inside the box?: {{ $cake->items }}</p>
            <p class="occasions text-lg lg:text-xl">Occasions: {{ $cake->occasions ? $cake->occasions : 'Not Applicable' }}</p>
            <p class="preptime text-lg lg:text-xl">Lead Time: {{ $cake->preptime }}</p>
            <p class="selfcollect text-lg lg:text-xl">
                Self Collect Availability: 
                @if ($cake->selfcollect === 1)
                    Yes
                @else
                    No
                @endif
            </p>
            <p class="cakesizes text-lg lg:text-xl mb-0">Cake Sizes Available:</p>
            <ul class="list-disc pl-5">
                @foreach($sizes as $key => $size)
                    @if(isset($size['enabled']) && $size['enabled'])
                        <li class="text-lg lg:text-xl">{{ ucfirst($key) }} - RM {{ number_format($size['price'], 2) }}</li>
                    @endif
                @endforeach
            </ul>
            <p class="addons text-lg lg:text-xl mb-0">Add-Ons Available:</p>
            <ul class="list-disc pl-5">
                @foreach($addons as $key => $addon)
                    @if(isset($addon['enabled']) && $addon['enabled'])
                        <li class="text-lg lg:text-xl">{{ ucfirst($key) }} - RM {{ number_format($addon['price'], 2) }}</li>
                    @endif
                @endforeach
            </ul>
            <p class="visible text-lg lg:text-xl">
                Product Availability: 
                @if ($cake->visible === 1)
                    Yes
                @else
                    No
                @endif
            </p>
        </div>
    </div>
</div>
<div class="mt-12 mb-5 text-center">
    <a href="{{ route('bakery.editproduct', $cake->id) }}" class="px-7 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold text-lg rounded-md">
        <i class="fa-solid fa-pen-to-square"></i> &nbsp;Edit Product
    </a>
</div>
<div class="mt-5 mb-14 text-center">
    <a href="{{ route('bakery.listproduct') }}" class="px-7 py-3 bg-green-500 hover:bg-green-600 font-bold text-lg text-white rounded-md">
        <i class="fa-solid fa-chevron-left"></i> &nbsp;Back to Menu
    </a>
</div>
@endsection
