@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/flowbite-datepicker@1.2.2/dist/js/datepicker-full.js"></script>
<link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
<style>
.form-control {
        display: block;
        width: 383px !important;
    }
</style>

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/customise-cake" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Cake Customisation</a>
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
<div class="container">
<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Customise you own cake now!') }}
</h1>
<div class="mx-20 applicationform">
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("When it comes to someone's birthday, anniversary, bridal shower or any special occasions, Bake Street is here to customise cake for you!") }}
    </p>
    <p class="pt-2 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("You can now self pick-up your customised cakes at our physical store. Please note that we require at least 3 working days of notice to ensure smooth ordering!") }}
    </p>
    <div id="self-pickup-address">
        <h5 class="mb-2 mt-5">Our store is located at:</h5>
        <p class="text-lg">Bake Street<br>No. 5, Jalan Universiti, Bandar Sunway, 47500 Subang Jaya, Selangor.<br>Tel: 03-12345678</p>
    </div>

    <h3 class="price font-bold pt-4">Customise now for RM 88.80</h3>
</div>
    <form action="{{ route('cakecustomisation.submit') }}" method="POST" enctype="multipart/form-data" class="mx-11 lg:mx-24 pt-3 mb-14 grid gap-10 lg:grid-cols-2">
        @csrf
        <div class="flex flex-col items-center">
        <div class="form-group">
            <label for="bakery_id" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Select Bakery</label>
            <select name="bakery_id" id="bakery_id" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
                @foreach($bakeries as $bakery)
                    <option value="{{ $bakery->id }}">{{ $bakery->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-start gap-4">
        <div class="form-group grid justify-items-center">
            <label for="quantity" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" max="100" value="1" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
        </div>
        <div class="grid justify-items-center">
        <label for="bigcandles" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Big Candles</label>
            <select id="bigcandles" name="bigcandlesqty" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm w-32" required>
                <option selected>No Candles</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="grid justify-items-center">
            <label for="smallcandles" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Small Candles</label>
            <select id="smallcandles" name="smallcandlesqty" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm w-32" required>
                <option selected>No Candles</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        </div>
        <div class="form-group">
            <label for="category" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Category</label>
            <select name="category" id="category" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            <option selected disabled>Choose Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="toppings" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Toppings</label>
            <select name="toppings" id="toppings" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            <option selected disabled>Choose Topping</option>    
                @foreach($toppings as $topping)
                    <option value="{{ $topping->id }}">{{ $topping->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="flavours" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Flavours</label>
            <select name="flavours" id="flavours" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            <option selected disabled>Choose Flavour</option>        
                @foreach($flavours as $flavour)
                    <option value="{{ $flavour->id }}">{{ $flavour->name }}</option>
                @endforeach
            </select>
        </div>

        <label for="message_on_cake" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Message on Cake</label>
        <div>
        <textarea id="message_on_cake" name="message_on_cake" rows="2" class="block p-2.5 w-96 text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-orange-400 focus:border-orange-400" placeholder="Write your message here..." maxlength="20"></textarea>
        </div>
        <label for="message_on_cake" class="block mb-4 text-sm text-xl text-gray-900 pt-1" id="cakeCharCount">Note: In English Only - 0/20 characters</label>

        <label for="message" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-2">Handwritten Gift Card</label>
        <div>
        <textarea id="message" name="cardmsg" rows="3" class="block p-2.5 w-96 text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-orange-400 focus:border-orange-400" placeholder="Write your message here..." maxlength="50"></textarea>
        </div>
        <label for="message" class="block mb-4 text-sm text-xl text-gray-900 pt-1" id="charCount">Note: In English Only - 0/50 characters</label>

        </div>
        <div>
        <!-- Personal Details -->
        <div class="form-group">
            <label for="cake_size" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Cake Size</label>
            <select name="cake_size" id="cake_size" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
                <option value="" disabled selected>Select a size</option>
                <option value="6 Inch">6 Inch</option>
                <option value="7 Inch">7 Inch </option>
                <option value="8 Inch">8 Inch</option>
                <option value="9 Inch">9 Inch</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cake_photo" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Upload Cake Photo</label>
            <input class="form-control" name="photo" type="file" id="photo">
            <p class="w-100">
            Please upload a photo to let us know what you're expecting.<br>
            The photo must be a JPEG, PNG, or JPG file.<br>
            Maximum size 2MB.
            </p>
        </div>
       

        <div class="form-group">
                <label for="name" class="block mb-2 text-sm font-bold text-xl text-gray-900">Name</label>
                <input type="text" name="name" id="name" placeholder="John Doe" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            </div>

            <div class="form-group">
                <label for="email" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Email Address</label>
                <input type="email" name="email" id="email" placeholder="example@email.com" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            </div>

            <div class="form-group">
                <label for="phone" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Phone Number</label>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            </div>

            <div class="form-group">
                <label for="address" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Billing Address</label>
                <textarea name="address" id="address" rows="4" placeholder="Billing Address" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required></textarea>
            </div>
        <p class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Selected date: <span id="selected_date"  name="selected_date"></span></p>
        <button type="button" id="schedule-button" data-modal-target="timepicker-modal" data-modal-toggle="timepicker-modal" class="text-black bg-amber-300 hover:bg-amber-500 focus:outline-none rounded-md active:bg-orange-500 text-lg font-semibold py-2 px-18 text-center w-96">
        <i class="fa-regular fa-clock"></i> Schedule Pick-Up
        </button>

        <input type="hidden" id="selected-time" name="selected_time">
        <input type="hidden" id="selected-date" name="selected_date">

        <!-- Main modal -->
        <div id="timepicker-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Schedule Your Pick-Up
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
                    <div class="pb-5" id="datepicker" inline-datepicker data-date="" data-min-date="" data-max-date=""></div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white mb-2 block">
                        Pick your time
                        </label>
                        <ul id="timetable" class="grid w-full grid-cols-3 gap-2 mb-4 pl-0">
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


        <div class="pt-10">
            <button type="submit" id="add-to-cart-button" value="Add Cart" class="bg-orange-500 hover:bg-amber-500 active:bg-orange-500 text-white text-2xl font-bold py-2.5 px-20 rounded w-96">
            <i class="fa-solid fa-cart-shopping fa-bounce"></i> &nbspPlace Order Now
            </button>
        </div>

        <!-- Button to open the ToS modal -->
        <button type="button" id="tos-button" class="text-gray-800 text-sm hover:text-black hover:font-semibold focus:outline-none rounded-md py-2" data-modal-target="tos-modal" data-modal-toggle="tos-modal">
        By placing an order, you have agreed to our terms of service.
        </button>

        <!-- ToS Modal -->
        <div id="tos-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 pb-3 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Terms of Service
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="tos-modal">
                            <svg class="w-3 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4">
                        <p>
                            <b>Here are a couple of things you should know upfront before you proceed with your order.</b><br>
                            The contact number reflected in this page will be contacted for confirmation.  Please ensure that this is the recipient's number.
                        </p>
                        <p>
                            - Cake customisation only allowed for pick-up.<br>
                            - Once orders are received, there is no turning back.  What this means is, refunds or changes to the orders will not be possible<br>
                            - No changes to orders are possible if they are less than 24-hours.<br>
                            - A hefty penalty fee applies to changes with less than 24-hours notice as the order would have been prepared and is scheduled to be shipped.<br>
                            - The cake is sold in one whole piece.
                        </p>
                        <div class="flex justify-end">
                            <button type="button" id="agree-button" class="text-white bg-green-500 hover:bg-green-600 rounded-md py-2 px-4" data-modal-hide="tos-modal">
                                I Agree
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</div>

<script>
const datapicker  = document.getElementById('datepicker');
document.getElementById('datepicker').addEventListener('changeDate', function(event) {
    document.getElementById('selected_date').textContent = event.detail.date.toLocaleDateString();
});

document.getElementById('message_on_cake').addEventListener('input', function() {
    var message = document.getElementById('message_on_cake');
    var charCount = document.getElementById('cakeCharCount');
    charCount.textContent = 'Note: In English Only - ' + message.value.length + '/20 characters used';
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
    // Change the button text to "Saved"
    saveButton.textContent = 'Saved';
    // Optionally, you can also disable the button to prevent multiple clicks
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
nextDay.setDate(today.getDate() + 4);
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
// Variable to store the selected date
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

    // Use the selectedDate variable here to pass the selected date value
    console.log('Selected date:', selectedDate);
    // You can now pass the selectedDate value to your backend or perform any other action
});

</script>
@endsection
