@extends('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/bakery/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/orderlist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Order Management</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="space-x-8 sm:-my-px ms-10 sm:flex mt-5 mb-4">
    @if (Auth::user()->usertype == 'bakery')
    <h1 class="text-left pl-2 font-semibold text-4xl text-gray-800 leading-tight">
        {{ __('Order Management') }}
    </h1>

        <!-- Search Bar -->
        <div class="searchbar pt-2  hidden md:flex sm:items-center sm:ms-6">
        <form action="{{ route('bakery.orders.search') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search by order id" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
        </form>
        </div>
    @endif
</div>



<ul class="grid w-full gap-8 md:grid-cols-2 px-12">
    <li>
    <a href="{{ route('bakery.orders.pending') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
        <div class="block">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M345.7 48.3L358 34.5c5.4-6.1 13.3-8.8 20.9-8.9c7.2 0 14.3 2.6 19.9 7.8c19.7 18.3 39.8 43.2 55 70.6C469 131.2 480 162.2 480 192.2C480 280.8 408.7 352 320 352c-89.6 0-160-71.3-160-159.8c0-37.3 16-73.4 36.8-104.5c20.9-31.3 47.5-59 70.9-80.2C273.4 2.3 280.7-.2 288 0c14.1 .3 23.8 11.4 32.7 21.6c0 0 0 0 0 0c2 2.3 4 4.6 6 6.7l19 19.9zM384 240.2c0-36.5-37-73-54.8-88.4c-5.4-4.7-13.1-4.7-18.5 0C293 167.1 256 203.6 256 240.2c0 35.3 28.7 64 64 64s64-28.7 64-64zM32 288c0-17.7 14.3-32 32-32l32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l0 64 448 0 0-64c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0c17.7 0 32 14.3 32 32l0 96c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32L32 512c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l0-96zM320 480a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm160-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM192 480a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
            <div class="w-full text-lg font-semibold text-black text-left">Pending Orders &nbsp;
                @if($availablePending)
                    <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                @endif 
            </div>
            <div class="w-full text-sm text-left pt-1">Review all pending orders to ensure timely preparation and delivery. This feature helps manage workflow and keeps customers satisfied with prompt service.</div>
        </div>
    </a>
    </li>

    <li>
    <a href="{{ route('bakery.orders.ready') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
        <div class="block">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 448 512"><path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/></svg>
            <div class="w-full text-lg font-semibold text-black text-left">Ready Orders &nbsp;
                @if($availableReady)
                    <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                @endif 
            </div>
            <div class="w-full text-sm text-left pt-1">Take a peek at the freshly baked cakes that are ready to be whisked away! Head over to 'Ready Orders' to see what delightful goodies are waiting to be sent.</div>
        </div>
    </a>
    </li>

    <li>
    <a href="{{ route('bakery.orders.upcoming') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
        <div class="block">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"/></svg>
            <div class="w-full text-lg font-semibold text-black text-left">Upcoming Orders &nbsp;
                @if($availableUpcoming)
                    <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                @endif 
            </div>
            <div class="w-full text-sm text-left pt-1">Get a head start on your baking schedule! See a list of orders that have been placed to plan your workflow and ensure all orders are prepared on time.</div>
        </div>
    </a>
    </li>

    <li>
    <a href="{{ route('bakery.orders.completed') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
    <div class="block">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                <div class="w-full text-lg font-semibold text-black text-left">Order History</div>
                <div class="w-full text-sm text-left pt-1">Revisit your baking triumphs! This section provides a record of all past orders, including those that have already been completed and picked up. </div>
            </div>
    </a>
    </li>
</ul>
<ul class="w-full px-12 py-6 pb-16">
    <li>
    <a href="{{ route('bakery.custom.orders') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
    <div class="block">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-cake-fill mb-2 w-7 h-7 text-sky-500 ml-1" viewBox="0 0 16 16">
                <path d="m7.399.804.595-.792.598.79A.747.747 0 0 1 8.5 1.806V4H11a2 2 0 0 1 2 2v3h1a2 2 0 0 1 2 2v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-4a2 2 0 0 1 2-2h1V6a2 2 0 0 1 2-2h2.5V1.813a.747.747 0 0 1-.101-1.01ZM12 6.414a.9.9 0 0 1-.646-.268 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0A.9.9 0 0 1 4 6.414v1c.49 0 .98-.187 1.354-.56a.914.914 0 0 1 1.292 0c.748.747 1.96.747 2.708 0a.914.914 0 0 1 1.292 0c.374.373.864.56 1.354.56zm2.646 5.732a.914.914 0 0 1-1.293 0 1.914 1.914 0 0 0-2.707 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0L1 11.793v1.34c.737.452 1.715.36 2.354-.28a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.708 0a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.707 0a.914.914 0 0 1 1.293 0 1.915 1.915 0 0 0 2.354.28v-1.34z"/>
                </svg>
                <div class="w-full text-lg font-semibold text-black text-left">Cake Customisation Orders &nbsp;
                @if($availableCustom)
                    <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                @endif 
            </div>
                <div class="w-full text-sm text-left pt-1">Review all custom cake orders to ensure timely preparation and delivery. This feature helps manage workflow and keeps customers satisfied with personalised and prompt service.</div>
            </div>
    </a>
    </li>
</ul>



@endsection
