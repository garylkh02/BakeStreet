@extends('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/admin/enquirylist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Enquiry Management</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="w-full px-10 lg:px-8 flex mt-5 mb-4">
    <h1 class="text-left pl-2 font-semibold text-4xl text-gray-800 leading-tight">
        {{ __('Enquiry Management') }}
    </h1>

        <!-- Search Bar -->
        <div class="searchbar pt-2 pr-1 hidden md:flex">
        <form action="{{ route('admin.enquirysearch') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search by email" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
        </form>
        </div>
</div>

<ul class="grid w-full gap-8 md:grid-cols-2 px-12">
    <li>
    <a href="{{ route('admin.userenquiry') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
        <div class="block">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ff6a00" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            <div class="w-full text-lg font-semibold text-black text-left">User Enquiry&nbsp;
            @if($contactUsPendingCount)
                <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
            @endif 
            </div>
            <div class="w-full text-sm text-left pt-1">Review all pending orders to ensure timely preparation and delivery. This feature helps manage workflow and keeps customers satisfied with prompt service.</div>
        </div>
    </a>
    </li>

    <li>
    <a href="{{ route('admin.bakeryenquiry') }}" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-800 hover:bg-gray-100 hover:border-orange-500 active:border-orange-300">
        <div class="block">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" aria-hidden="true" class="bi bi-bag-heart mb-2 w-7 h-7 text-sky-500" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M86.4 5.5L61.8 47.6C58 54.1 56 61.6 56 69.2V72c0 22.1 17.9 40 40 40s40-17.9 40-40V69.2c0-7.6-2-15-5.8-21.6L105.6 5.5C103.6 2.1 100 0 96 0s-7.6 2.1-9.6 5.5zm128 0L189.8 47.6c-3.8 6.5-5.8 14-5.8 21.6V72c0 22.1 17.9 40 40 40s40-17.9 40-40V69.2c0-7.6-2-15-5.8-21.6L233.6 5.5C231.6 2.1 228 0 224 0s-7.6 2.1-9.6 5.5zM317.8 47.6c-3.8 6.5-5.8 14-5.8 21.6V72c0 22.1 17.9 40 40 40s40-17.9 40-40V69.2c0-7.6-2-15-5.8-21.6L361.6 5.5C359.6 2.1 356 0 352 0s-7.6 2.1-9.6 5.5L317.8 47.6zM128 176c0-17.7-14.3-32-32-32s-32 14.3-32 32v48c-35.3 0-64 28.7-64 64v71c8.3 5.2 18.1 9 28.8 9c13.5 0 27.2-6.1 38.4-13.4c5.4-3.5 9.9-7.1 13-9.7c1.5-1.3 2.7-2.4 3.5-3.1c.4-.4 .7-.6 .8-.8l.1-.1 0 0 0 0s0 0 0 0s0 0 0 0c3.1-3.2 7.4-4.9 11.9-4.8s8.6 2.1 11.6 5.4l0 0 0 0 .1 .1c.1 .1 .4 .4 .7 .7c.7 .7 1.7 1.7 3.1 3c2.8 2.6 6.8 6.1 11.8 9.5c10.2 7.1 23 13.1 36.3 13.1s26.1-6 36.3-13.1c5-3.5 9-6.9 11.8-9.5c1.4-1.3 2.4-2.3 3.1-3c.3-.3 .6-.6 .7-.7l.1-.1c3-3.5 7.4-5.4 12-5.4s9 2 12 5.4l.1 .1c.1 .1 .4 .4 .7 .7c.7 .7 1.7 1.7 3.1 3c2.8 2.6 6.8 6.1 11.8 9.5c10.2 7.1 23 13.1 36.3 13.1s26.1-6 36.3-13.1c5-3.5 9-6.9 11.8-9.5c1.4-1.3 2.4-2.3 3.1-3c.3-.3 .6-.6 .7-.7l.1-.1c2.9-3.4 7.1-5.3 11.6-5.4s8.7 1.6 11.9 4.8l0 0 0 0 0 0 .1 .1c.2 .2 .4 .4 .8 .8c.8 .7 1.9 1.8 3.5 3.1c3.1 2.6 7.5 6.2 13 9.7c11.2 7.3 24.9 13.4 38.4 13.4c10.7 0 20.5-3.9 28.8-9V288c0-35.3-28.7-64-64-64V176c0-17.7-14.3-32-32-32s-32 14.3-32 32v48H256V176c0-17.7-14.3-32-32-32s-32 14.3-32 32v48H128V176zM448 394.6c-8.5 3.3-18.2 5.4-28.8 5.4c-22.5 0-42.4-9.9-55.8-18.6c-4.1-2.7-7.8-5.4-10.9-7.8c-2.8 2.4-6.1 5-9.8 7.5C329.8 390 310.6 400 288 400s-41.8-10-54.6-18.9c-3.5-2.4-6.7-4.9-9.4-7.2c-2.7 2.3-5.9 4.7-9.4 7.2C201.8 390 182.6 400 160 400s-41.8-10-54.6-18.9c-3.7-2.6-7-5.2-9.8-7.5c-3.1 2.4-6.8 5.1-10.9 7.8C71.2 390.1 51.3 400 28.8 400c-10.6 0-20.3-2.2-28.8-5.4V480c0 17.7 14.3 32 32 32H416c17.7 0 32-14.3 32-32V394.6z"/></svg>
            <div class="w-full text-lg font-semibold text-black text-left">Bakery Enquiry&nbsp;
            @if($bContactUsPendingCount)
                <i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
            @endif 
            </div>
            <div class="w-full text-sm text-left pt-1">Take a peek at the freshly baked cakes that are ready to be whisked away! Head over to 'Ready Orders' to see what delightful goodies are waiting to be sent.</div>
        </div>
    </a>
    </li>

</ul>
@endsection
