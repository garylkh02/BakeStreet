<x-app-layout>

@section('content')
<script src="https://unpkg.com/flowbite-datepicker@1.2.2/dist/js/datepicker-full.js"></script>
<link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/allproducts" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp All Products &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/allproducts/{{ $cake->id }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $cake->name }}</a>
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

<div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8 mb-20">
<form action="{{ route('cart.store', $cake->id) }}" method="POST">
    @csrf 
<div class="grid lg:grid-rows-1 lg:grid-cols-2">
<!-- When the screen is minimised then change to grid grid-rows-2 gap-1 -->
    <div class="cake-page pt-2  hidden lg:block">
    <img src="{{ asset($cake->photo) }}" alt="Cake Photo" style="position: relative; overflow: hidden;" class="w-20 h-20 object-cover rounded-t-lg">
    <div class="line py-2 bg-amber-400 text-white font-bold text-xl rounded-b-lg">Available only in {{ $cake->bakery->location }}</div>

        <h5 class="pt-4">Share via&nbsp;&nbsp;&nbsp;
            <a href="https://www.facebook.com/sharer/sharer.php?u=#url"><i class="fa-brands fa-facebook fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
            <a href="https://twitter.com/intent/tweet"><i class="fa-brands fa-x-twitter fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
            <a href="https://www.instagram.com/accounts/login/?hl=en"><i class="fa-brands fa-instagram fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
            <a href="whatsapp://send?text=Check out this page: /allproducts/{{ $cake->id }}"><i class="fa-brands fa-whatsapp fa-xl" style="color: #ffaa00;"></i></a>
        </h5>   

        
    <div id="reviews" class="reviews w-10/12">
    <h2 class="text-2xl mt-8 font-bold">Reviews</h2>
    @if ($reviews->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">There are no reviews yet.</p>
    @else
        @foreach($displayReviews as $displayReview)
            <div class="review">
                <div class="flex items-center mb-1">
                    <div class="font-medium dark:text-white">
                        {{ $displayReview->user->name }}
                        <time datetime="{{ $displayReview->created_at->format('Y-m-d H:i') }}" class="block text-sm text-gray-500 dark:text-gray-400 pb-2">Reviewed on {{ $displayReview->created_at->format('F d, Y') }}</time>
                        <x-star-rating :rating="$displayReview->rating"/>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $displayReview->review }}</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-400 dark:border-gray-400 pb-2"></div>
        @endforeach
    @endif
    </div>
    </div>
    
    <div class="cake-page pt-2 lg:hidden flex flex-col items-center">
        <img src="{{ asset($cake->photo) }}" alt="Cake Photo" style="position: relative; overflow: hidden;" class="w-16 h-16 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-20 lg:h-20 object-cover rounded-t-lg">
        <div class="line py-2 bg-amber-400 text-white font-bold text-xl sm:text-lg md:text-xl lg:text-2xl rounded-b-lg text-center w-full">Available only in {{ $cake->bakery->location }}</div>
        <br>
    </div>

    <div class="mx-3">
    <div class="cake-header">
        @if($cake->original_price && $cake->price < $cake->original_price)
        <div class="flex">
        <h1 class="font-bold">{{ $cake->name }}</h1>&nbsp;&nbsp;&nbsp;
        <h3 class="self-center px-2 py-1 text-lg font-bold text-white h-9 bg-red-600">SALE</h3>
        </div>
        @else
        <h1 class="font-bold">{{ $cake->name }}</h1>
        @endif
        &nbsp;&nbsp;&nbsp;
        @if(Auth::check())
            <i class="fa-regular fa-heart wishlist-icon {{ Auth::user()->wishlist->contains($cake->id) ? 'wishlist-added fa-solid' : 'wishlist-removed' }}" data-cake-id="{{ $cake->id }}"></i>
        @else
            <i class="fa-regular fa-heart wishlist-icon wishlist-removed" data-cake-id="{{ $cake->id }}"></i>
        @endif
    </div>
        <p class="pl-1 mb-0">
            by the <a href="{{ route('bakeries.profile', $cake->bakery_id) }}" class="text-amber-500 hover:text-orange-500">{{ $cake->bakery->name }}</a>
            @if($cake->reviews->avg('rating'))
            <div class="flex items-center h-7 pl-1">
                <svg class="w-4 h-4 text-yellow-300 me-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <p class="ms-2 text-sm font-bold text-gray-900 pt-3">{{ number_format($averageRating, 1) }}</p>
                <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                <a href="#reviews" class="text-sm font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">{{ $reviewCount }} reviews</a>
            </div>
            @else
            <div class="flex items-center h-7 pl-1">
            <a href="#reviews" class="text-sm font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">No ratings yet</a>
            </div>
            @endif
        <form class="pl-1 mb-0 pt-2">
            <label for="quantity-input" class="block mb-2 font-medium text-gray-900 dark:text-white">Choose quantity:</label>
            <div class="relative flex items-center max-w-[8rem]">
                <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                    </svg>
                </button>
                <input type="text" name="quantity" id="quantity-input" data-input-counter data-input-counter-min="1" data-input-counter-max="50" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="999" value="1" required />
                <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </button>
            </div>
        </form>
        </p>
        
        @if($cake->original_price && $cake->price < $cake->original_price)
        <div class="flex">
        <h3 class="price pl-1 font-bold"><span style="text-decoration: line-through;">RM {{ number_format($cake->original_price, 2) }}</h3>&nbsp;&nbsp;
        <h3 class="price pl-1 font-bold"><span style="color: red;">RM {{ number_format($cake->price, 2) }}</span></h3>
        </div>
        @else
        <h3 class="price pl-1 font-bold">RM {{ $cake->price }}</h3>
        @endif

        <p class="description pl-1">{{ $cake->description }}</p>
        <div class="bg-transparent accordion max-w-screen-xl mx-auto sm:px-6 lg:px-8 pt-0 pl-1" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            Cake Details
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Flavour: {{ $cake->flavour->name }}<br>Category: {{ $cake->category->name }}<br>Occasions: {{ $cake->occasions ? $cake->occasions : 'Not Applicable' }}</strong>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-amber-400" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Ingredients
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body w-80">
                <strong>{{ $cake->ingredients }}</strong>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Allergens
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>{{ $cake->allergens }}</strong>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Items provided with your order
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>{{ $cake->items }}</strong>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Cake Care Instructions
            </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>{{ $cake->cakecare }}</strong>
            </div>
            </div>
        </div>
        </div>
        <label for="message" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4 pl-1">Candles</label>

        <div class="pl-1">
            <label for="bigcandles" class="block mb-2 font-medium text-gray-900">Big Candles</label>
            <select id="bigcandles" name="bigcandlesqty" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-400 focus:border-orange-400 block w-full p-2.5">
                <option selected>No Candles</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
     
            <label for="smallcandles" class="block mb-2 font-medium text-gray-900 pt-3">Small Candles</label>
            <select id="smallcandles" name="smallcandlesqty" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-400 focus:border-orange-400 block w-full p-2.5">
                <option selected>No Candles</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        
        <div class="pl-1">
            <label for="size" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Select Cake Size:</label>
            <select name="size" id="size" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-400 focus:border-orange-400 block w-full p-2.5">
                @foreach($sizes as $key => $size)
                    @if(isset($size['enabled']) && $size['enabled'])
                        <option value="{{ $key }}">{{ ucfirst($key) }} - RM {{ number_format($size['price'], 2) }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="pl-1">
            <label class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Add-ons Available:</label>
            @foreach($addons as $key => $addon)
                @if(isset($addon['enabled']) && $addon['enabled'])
                    <div>
                        <input type="checkbox" name="addons[]" value="{{ $key }}"> {{ ucfirst($key) }} - RM {{ number_format($addon['price'], 2) }}
                    </div>
                @endif
            @endforeach
        </div>
        
        <label for="message" class="block mb-2 text-sm font-bold text-xl text-gray-900 pl-1 pt-4">Handwritten Gift Card</label>
        <div class="pl-1">
        <div>
        <textarea id="message" name="cardmsg" rows="3" class="block p-2.5 w-full text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-orange-400 focus:border-orange-400" placeholder="Write your message here..." maxlength="50"></textarea>
        </div>
        <label for="message" class="block mb-4 text-sm text-xl text-gray-900 pl-1 pt-1" id="charCount">Note: In English Only - 0/50 characters</label>
      
        <p class="pb-0">Selected date: <span id="selected_date"  name="selected_date"></span></p>
        <button type="button" id="schedule-button" data-modal-target="timepicker-modal" data-modal-toggle="timepicker-modal" class="text-black bg-amber-300 hover:bg-amber-500 focus:outline-none rounded-md active:bg-orange-500 text-xl lg:text-2xl font-semibold py-2.5 px-20 text-center w-full">
        <i class="fa-regular fa-clock"></i> Schedule Delivery / Pick Up
        </button>

        <input type="hidden" id="selected-time" name="selected_time">
        <input type="hidden" id="selected-date" name="selected_date">

<!-- Main modal -->
<div id="timepicker-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-md md:max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Schedule Delivery / Pick Up
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="timepicker-modal">
                    <svg class="w-3 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4">
                <div class="pb-5 flex flex-col items-center" id="datepicker" inline-datepicker data-date="" data-min-date="" data-max-date=""></div>
                <label class="text-sm font-medium text-gray-900 dark:text-white mb-2 block">
                    Pick your time
                </label>
                <ul id="timetable" class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-4 pl-0">
                    <li>
                        <input type="radio" id="11-am" value="11:00 AM" class="hidden peer" name="timetable">
                        <label for="11-am"
                            class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                            11:00 AM
                        </label>
                    </li>
                            <li>
                                <input type="radio" id="12-pm" value="12:00 PM" class="hidden peer" name="timetable">
                                <label for="12-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                12:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="1-pm" value="01:00 PM" class="hidden peer" name="timetable" checked>
                                <label for="1-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                01:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="2-pm" value="02:00 PM" class="hidden peer" name="timetable">
                                <label for="2-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                02:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="3-pm" value="03:00 PM" class="hidden peer" name="timetable">
                                <label for="3-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                03:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="4-pm" value="04:00 PM" class="hidden peer" name="timetable">
                                <label for="4-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                04:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="5-pm" value="05:00 PM" class="hidden peer" name="timetable">
                                <label for="5-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                05:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="6-pm" value="06:00 PM" class="hidden peer" name="timetable">
                                <label for="6-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                06:00 PM
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="7-pm" value="07:00 PM" class="hidden peer" name="timetable">
                                <label for="7-pm"
                                class="inline-flex items-center justify-center w-full px-2 py-1 text-sm font-medium text-center hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 border rounded-lg cursor-pointer text-gray-500 border-gray-200 dark:border-gray-700 dark:peer-checked:border-blue-500 peer-checked:border-blue-700 dark:hover:border-gray-600 dark:peer-checked:text-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-600 dark:peer-checked:bg-blue-900">
                                07:00 PM
                                </label>
                            </li>
                        </ul>
                        <div class="grid grid-cols-2 gap-2">
                    <button type="button" id="save-time" class="text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:ring-green-300 font-bold rounded-lg py-2.5 mb-2 focus:outline-none">Save</button>
                    <button type="button" data-modal-hide="timepicker-modal" class="py-2.5 mb-2 font-bold text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-orange-500 focus:z-10 focus:ring-4 focus:ring-gray-100">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="pt-4 pl-1">
        <button type="submit" id="add-to-cart-button" value="Add Cart" class="bg-amber-400 hover:bg-amber-500 active:bg-orange-500 text-white text-2xl font-bold py-2.5 px-20 rounded w-full">
            <i class="fa-solid fa-cart-shopping fa-bounce"></i> &nbspAdd to Cart
        </button>
    </div>
    </div>
</form>
</div>

<div id="reviews" class="reviews w-10/12 lg:w-full lg:max-w-screen-lg mx-auto justify-center lg:hidden">
    <h2 class="text-2xl mt-8 font-bold text-center">Reviews</h2>
    @if ($reviews->isEmpty())
        <p class="text-gray-500 dark:text-gray-400 text-center">There are no reviews yet.</p>
    @else
        @foreach($displayReviews as $displayReview)
            <div class="review">
                <div class="flex items-center mb-1">
                    <div class="font-medium dark:text-white">
                        {{ $displayReview->user->name }}
                        <time datetime="{{ $displayReview->created_at->format('Y-m-d H:i') }}" class="block text-sm text-gray-500 dark:text-gray-400 pb-2">Reviewed on {{ $displayReview->created_at->format('F d, Y') }}</time>
                        <x-star-rating :rating="$displayReview->rating"/>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $displayReview->review }}</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-400 dark:border-gray-400 pb-2"></div>
        @endforeach
    @endif
    <br>
    <h5 class="pt-4">Share via&nbsp;&nbsp;&nbsp;
        <a href="https://www.facebook.com/sharer/sharer.php?u=#url"><i class="fa-brands fa-facebook fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
        <a href="https://twitter.com/intent/tweet"><i class="fa-brands fa-x-twitter fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
        <a href="https://www.instagram.com/accounts/login/?hl=en"><i class="fa-brands fa-instagram fa-xl" style="color: #ffaa00;"></i></a>&nbsp;&nbsp;
        <a href="whatsapp://send?text=Check out this page: /allproducts/{{ $cake->id }}"><i class="fa-brands fa-whatsapp fa-xl" style="color: #ffaa00;"></i></a>
    </h5>   
</div>


<h1 class="block mb-3 font-bold text-3xl text-gray-900 pl-1 pt-16 px-4">We Also Recommend</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-4">
    @foreach($recommendedCakes as $recommendedCake)
        <a href="/allproducts/{{ $recommendedCake->id }}" class="flex items-center px-4 shadow-md rounded-lg bg-gray-50 block hover:bg-gray-100 transition-colors">
            <img src="{{ asset($recommendedCake->photo) }}" alt="{{ $recommendedCake->name }}" class="w-24 h-24 object-cover rounded-md">
            <div class="ml-5">
                <p class="text-lg font-semibold text-gray-900 hover:text-orange-500 mb-3 mt-3">{{ $recommendedCake->name }}</p>
                <p class="text-sm font-semibold text-amber-500 mb-0">from</p>
                <p class="text-lg font-bold text-gray-800 mt-0 mb-0">RM {{ number_format($recommendedCake->price, 2) }}</p>
                <p class="text-sm text-gray-500 mt-0">{{ $recommendedCake->bakery->name }}</p>
            </div>
        </a>
    @endforeach
</div>



<script>
const datapicker  = document.getElementById('datepicker');
document.getElementById('datepicker').addEventListener('changeDate', function(event) {
    document.getElementById('selected_date').textContent = event.detail.date.toLocaleDateString();
});
    
document.getElementById('message').addEventListener('input', function() {
    var message = document.getElementById('message');
    var charCount = document.getElementById('charCount');
    charCount.textContent = 'Note: In English Only - ' + message.value.length + '/50 characters used';
});

document.getElementById('save-time').addEventListener('click', function () {
    const selectedTime = document.querySelector('input[name="timetable"]:checked').value;
    document.getElementById('selected-time').value = selectedTime;
    
    // Update the button text with selected date and time
    const selectedDateTime = selectedTime;
    document.getElementById('schedule-button').textContent = "Delivery / Pickup Time: " + selectedDateTime;
});

// Select the button element
const saveButton = document.getElementById('save-time');

// Add a click event listener to the button
saveButton.addEventListener('click', function() {
    saveButton.textContent = 'Saved';
    saveButton.disabled = true;
});

// Listen for the modal to be hidden
document.addEventListener('click', function(event) {
    // Check if the click event is targeting the modal hide button
    if (event.target.dataset.modalHide === 'timepicker-modal') {
        // Change the button text back to "Save"
        saveButton.textContent = 'Save';
        // Enable the button
        saveButton.disabled = false;
    }
});

// Calculate the next day
const today = new Date();
const nextDay = new Date(today);
const maxDay = new Date(today);
nextDay.setDate(today.getDate() + 1);
maxDay.setDate(today.getDate() + 21);


// Format the date as "MM/DD/YYYY"
const formattedDate = (nextDay.getMonth() + 1).toString().padStart(2, '0') + '/' + nextDay.getDate().toString().padStart(2, '0') + '/' + nextDay.getFullYear();
const formattedMaxDate = (maxDay.getMonth() + 1).toString().padStart(2, '0') + '/' + maxDay.getDate().toString().padStart(2, '0') + '/' + maxDay.getFullYear();
// Set the default date in the data-date attribute
document.getElementById('datepicker').setAttribute('data-date', formattedDate);
document.getElementById('datepicker').setAttribute('data-min-date', formattedDate);
document.getElementById('datepicker').setAttribute('data-max-date', formattedMaxDate);

const datepickerElement = document.getElementById('datepicker');
const datepicker = new Datepicker(datepickerElement, {
    todayHighlight: true,
    minDate: nextDay,
    maxDate: maxDay
});

let selectedDate = new Date();

// Event listener for datepicker changeDate event
document.getElementById('datepicker').addEventListener('changeDate', function(event) {
    // Get the selected date from the event
    selectedDate = event.detail.date;
    
    // Format the selected date as YYYY-MM-DD
    changedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1).toString().padStart(2, '0') + '-' + selectedDate.getDate().toString().padStart(2, '0');
    
    // Set the formatted date to the hidden input field
    document.getElementById('selected-date').value = changedDate;
});


// Event listener for add to cart button click
document.getElementById('add-to-cart-button').addEventListener('click', function() {
    const selectedDate = document.getElementById('selected-date').value;
    const selectedTime = document.getElementById('selected-time').value;

    if (!selectedDate || !selectedTime) {
        event.preventDefault(); // Prevent form submission
        alert('Please select a date and time for delivery or pickup.');
    }

    console.log('Selected date:', selectedDate);
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wishlist-icon').forEach(function (icon) {
        icon.addEventListener('click', function () {
            const cakeId = this.getAttribute('data-cake-id');
            const isFilled = this.classList.contains('fa-solid'); 

            const url = isFilled ? '/wishlist/remove' : '/wishlist/add';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ cake_id: cakeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'not_logged_in') {
                    window.location.href = '/login';
                } else if (data.status === 'added') {
                    this.classList.remove('fa-regular', 'wishlist-removed');
                    this.classList.add('fa-solid', 'wishlist-added');
                } else if (data.status === 'removed') {
                    this.classList.remove('fa-solid', 'wishlist-added');
                    this.classList.add('fa-regular', 'wishlist-removed');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>


@endsection
</x-app-layout>