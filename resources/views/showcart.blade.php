<x-app-layout>
@section('content')

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/cart" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Shopping Cart</a>
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

<section class="h-100 h-custom pb-5">
  <div class="container py-4 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12">
        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
          <div class="card-body p-0">
            <div class="row g-0">
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fw-bold mb-0 text-gray-800">Basket</h1>
                    <h6 class="mb-0 text-muted">{{ $cartCount }} item/s</h6>
                  </div>
              <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf     
                @foreach($cart as $carts)
                <hr class="my-4">
                <div class="row mb-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="col-6 col-md-2">
                        <img src="{{ asset($carts->cake->photo) }}" alt="{{ $carts->cake->name }}" class="img-fluid rounded-3">
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="/allproducts/{{$carts->cake->id }}" class="text-orange-500 text-lg font-semibold mb-0 hover:text-amber-500">{{ $carts->cake->name }}</a>
                        <input type="text" name="producttitle[]" value="{{$carts->cake->name}}" hidden>
                        <input type="text" name="cakeid[]" value="{{$carts->cake->id}}" hidden>
                        <h6 class="text-gray-700 text-sm mb-0">Big & Small Candles: {{$carts->bcandle}} &nbsp;|&nbsp; {{$carts->scandle}}</h6>
                        <input type="text" name="bcandle[]" value="{{$carts->bcandle}}" hidden>
                        <input type="text" name="scandle[]" value="{{$carts->scandle}}" hidden>

                        @if($carts->message)
                        <h6 class="text-gray-700 text-sm mb-0">Message: {{$carts->message}}</h6>
                        @else
                        <h6 class="text-gray-700 text-sm mb-0">No Card Message</h6>
                        @endif
                        <input type="text" name="message[]" value="{{$carts->message}}" hidden>

                        <h6 class="text-gray-700 text-sm mb-0">Size: {{$carts->size}}</h6>
                        <input type="text" name="size[]" value="{{$carts->size}}" hidden>
                        
                        @if($carts->addons)
                            @php
                                $selectedAddons = json_decode($carts->addons, true);
                            @endphp
                            @if($selectedAddons)
                            <div class="addons flex">
                                <h6 class="text-gray-700 text-sm mb-0">Add-Ons:</h6>
                                @foreach($selectedAddons as $addonKey => $addonValue)
                                <h6 class="text-gray-700 mb-0 text-sm flex">&nbsp;| {{ ucfirst($addonKey) }}</h6>
                                @endforeach
                            </div>
                            @else
                            <h6 class="text-sm text-gray-700 mb-0">No add-ons selected.</h6>
                            @endif
                        @endif

                        <h6 class="text-gray-700 text-sm mb-0">Delivery Date & Time:</h6>
                        <input type="text" name="deldate[]" value="{{$carts->deldate}}" hidden>
                        <input type="text" name="deltime[]" value="{{$carts->deltime}}" hidden>
                        <h6 class="text-orange-400 text-sm font-semibold mb-0">{{$carts->deldate}} &nbsp;|&nbsp; {{$carts->deltime}}</h6>
                    </div>
                
                    <div class="col-12 col-md-3 d-flex mt-3 mt-md-0">
                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                            onclick="this.parentNode.querySelector('input[type=number]').stepDown(); updateCartQuantity(this.parentNode.querySelector('input[type=number]'));">
                            <i class="fa-solid fa-minus text-amber-500"></i>
                        </button>
                        <input id="form1" min="1" name="quantity[]" value="{{$carts->quantity}}" type="number"
                            class="form-control form-control-sm" data-cart-id="{{ $carts->id }}" onchange="updateCartQuantity(this)" style="text-align: center;"/>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                            onclick="this.parentNode.querySelector('input[type=number]').stepUp(); updateCartQuantity(this.parentNode.querySelector('input[type=number]'));">
                            <i class="fa-solid fa-plus text-amber-500"></i>
                        </button>
                    </div>
                    
                    <div class="col-6 col-md-2 mt-3 mt-md-0">
                        <h6 class="mb-0">RM {{$carts->total_price}}</h6>
                    </div>
                    <input type="text" name="price[]" value="{{$carts->price}}" hidden>
                    
                    <div class="col-12 col-md-1 text-end d-flex justify-content-end align-items-center mt-3 mt-md-0">
                        <button type="button" class="text-muted me-2" onclick='openModal(@json($carts))'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="{{ route('cart.delete', $carts->id) }}" class="text-muted"><i class="fas fa-times"></i></a>
                    </div>
                </div>
                @endforeach

                <hr class="my-4">
                <div class="pt-5 hover:text-orange-500">
                <h6 class="mb-0"><a href="/allproducts" class="text-body text-lg"><i class="fa-solid fa-angles-left" style="color: #ffaa00;"></i>&nbsp;Back to shop</a></h6>
                </div>
                </div>
                </div>
                <div class="col-lg-4 bg-grey">
                  <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                  <hr class="my-4">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                  <h5 class="mb-0">Subtotal</h5>
                  <h5 class="mb-0">RM {{ number_format($subtotal, 2) }}</h5>
                  </div>

                  <div class="d-flex justify-content-between align-items-cente mb-3">            
                  <h5 class="mb-0">SST (6%)</h5>
                  <h5 class="mb-0">RM {{ number_format($serviceTax, 2) }}</h5>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 font-bold">Total Price</h5>
                        <p class="mb-0 ms-1">(incl. VAT)</p>
                    </div>
                        <h5 class="mb-0 font-bold">RM {{ number_format($totalPrice, 2) }}</h5>   
                </div>
                @if($cart->isNotEmpty())
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-light btn-block btn-lg custom-buttonwidth" data-mdb-ripple-color="dark">
                        Place Order
                    </button>
                @else
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-light btn-block btn-lg custom-buttonwidth" data-mdb-ripple-color="dark" disabled>
                        Place Order
                    </button>
                @endif

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
                                        The contact number reflected in the checkout page (next page) will be contacted on the day of delivery.  Please ensure that this is the recipient's number.
                                    </p>
                                    <p>
                                        - Very rarely does it occur, but should ordered cakes become unavailable, we will make it up to you with the next best tasting cake – of matching value.<br>
                                        - Once orders are received, there is no turning back.  What this means is, refunds or changes to the orders will not be possible<br>
                                        - No changes to orders are possible if they are less than 24-hours.<br>
                                        - A hefty penalty fee applies to changes with less than 24-hours notice as the order would have been prepared and is scheduled to be shipped.<br>
                                        - There are different lead times required to make the cake, it ranges from 5-hours to 3-days.  Planning your orders while observing the lead times will ensure timely delivery.<br>
                                        - The cake is delivered in one whole piece.
                                    </p>
                                    <p>
                                        <b>COURTESY REMINDER</b><br>
                                        - If you intend to send a surprise cake to a recipient on their birthday, our observation tells us that they tend to take time off.  So be sure to check if they will be in on that very fine day!<br>
                                        - If you would like for us to leave the cake at any guard house, please ensure there is a fridge for food storage purposes. Otherwise, the lovingly baked cakes will end up getting attacked by a legion of ants.  #TRUESTORY<br>
                                        - If you would like to change delivery date and time, please ensure to get us informed at least 24 hours ahead of the delivery date by calling our Customer Service team at 03-12345678. <br>
                                        - If you would like to cancel the order, please ensure to get us informed at least 36 hours ahead by calling our Customer Service team at 03-12345678. However, the value of the order can only be credited as gift card to the purchaser's Bake Street's Account and not as a direct refund.
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
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
      
      <h1 class="block mb-3 font-bold text-3xl text-gray-900 pl-1 pt-16">We Also Recommend</h1>
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4">
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
    </div>
  </div>


<div class="container">
    <br>
    <br>
    <h3 class="text-center pt-3">Payment Methods:</h3>
    <div class="d-flex justify-content-center align-items-center">
        <img src="/img/visa.png" alt="Visa" class="payment-method">
        <img src="/img/mastercard.svg" alt="Mastercard" class="payment-method mx-3">
        <img src="/img/fpx.png" alt="FPX" class="payment-method">
        <img src="/img/apple.svg" alt="Apple Pay" class="payment-method mx-3">
        <img src="/img/googlepay.png" alt="Google Pay" class="payment-method">
    </div>
</div>
</section>

@if($cart->isNotEmpty())
<div id="editOrderModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative w-full max-w-2xl pb-8 pt-0 bg-amber-50 rounded-lg shadow-lg">
        <img src="{{ asset($carts->cake->photo) }}" alt="Cake Image" class="w-full h-52 object-cover" style="border-top-left-radius: 6px; border-top-right-radius: 6px;">
            <div class="flex justify-between items-center mb-2 px-8">
                <h3 class="text-3xl font-semibold text-gray-900 mt-3">{{ $carts->cake->name }}</h3>
                <button class="text-gray-400 hover:text-gray-600 mt-3" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editOrderForm" method="POST">    
                @csrf
                <input type="hidden" name="cart_id" id="editCartId">
                <div class="flex justify-between">
                <div class="grid justify-items-center mb-4 px-8">
                    <label for="editQuantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="editQuantity" min="1" max="100" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="grid justify-items-center mb-4 px-8">
                    <label for="editBigCandles" class="block text-sm font-medium text-gray-700">Big Candles</label>
                    <input type="number" name="bcandle" id="editBigCandles" min="0" max="10" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="grid justify-items-center mb-4 px-8">
                    <label for="editSmallCandles" class="block text-sm font-medium text-gray-700">Small Candles</label>
                    <input type="number" name="scandle" id="editSmallCandles" min="0" max="10" class="block w-14 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                </div>
                <div class="mb-4 px-8">
                  <label for="editMessage" class="block text-sm font-medium text-gray-700">Message</label>
                  <label for="message" class="block text-sm font-medium text-gray-600" id="charCount">Note: In English Only - 0/50 characters</label>
                  <input type="text" name="message" id="editMessage" maxlength="50" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4 px-8">
                    <label for="editDeliveryDate" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                    <input type="date" name="deldate" id="editDeliveryDate" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

              <!-- Radio Button Time Selection -->
              <label for="editDeliveryDate" class="block text-sm font-medium text-gray-700 px-8 pb-1">Delivery Time</label>
              <ul id="timetable" class="grid w-full grid-cols-3 gap-2 mb-5 px-8">
                <li>
                    <input type="radio" id="11-am" value="11:00 AM" class="hidden peer" name="timetable">
                    <label for="11-am" class="time-selection-label">11:00 AM</label>
                </li>
                <li>
                    <input type="radio" id="12-pm" value="12:00 PM" class="hidden peer" name="timetable">
                    <label for="12-pm" class="time-selection-label">12:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="1-pm" value="01:00 PM" class="hidden peer" name="timetable">
                    <label for="1-pm" class="time-selection-label">01:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="2-pm" value="02:00 PM" class="hidden peer" name="timetable">
                    <label for="2-pm" class="time-selection-label">02:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="3-pm" value="03:00 PM" class="hidden peer" name="timetable">
                    <label for="3-pm" class="time-selection-label">03:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="4-pm" value="04:00 PM" class="hidden peer" name="timetable">
                    <label for="4-pm" class="time-selection-label">04:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="5-pm" value="05:00 PM" class="hidden peer" name="timetable">
                    <label for="5-pm" class="time-selection-label">05:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="6-pm" value="06:00 PM" class="hidden peer" name="timetable">
                    <label for="6-pm" class="time-selection-label">06:00 PM</label>
                </li>
                <li>
                    <input type="radio" id="7-pm" value="07:00 PM" class="hidden peer" name="timetable">
                    <label for="7-pm" class="time-selection-label">07:00 PM</label>
                </li>
            </ul>


                <!-- Hidden Input for Delivery Time -->
                <input type="hidden" name="deltime" id="editDeliveryTime">
                <div class="flex justify-end px-8">
                    <button type="button" class="px-4 py-2 text-white font-semibold bg-gray-500 rounded-md hover:bg-gray-600" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="ml-3 px-4 py-2 text-white font-semibold bg-amber-500 rounded-md hover:bg-orange-500">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


<script>
function updateCartQuantity(inputElement) {
    var cartId = inputElement.getAttribute('data-cart-id');
    var quantity = inputElement.value;

    fetch('/cart/update-quantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Quantity updated successfully');
            if (data.reload) {
                location.reload(); // Reload the page
            }
            // Optionally, update the UI to reflect the change
        } else {
            console.error('Failed to update quantity');
        }
    })
}

function openModal(cart) {
    document.getElementById('editCartId').value = cart.id;
    document.getElementById('editOrderForm').action = '/cart/update/' + cart.id;
    document.getElementById('editQuantity').value = cart.quantity;
    document.getElementById('editBigCandles').value = cart.bcandle;
    document.getElementById('editSmallCandles').value = cart.scandle;
    document.getElementById('editMessage').value = cart.message;
    document.getElementById('editDeliveryDate').value = cart.deldate;
    document.getElementById('editDeliveryTime').value = cart.deltime;
    document.getElementById('editOrderModal').classList.remove('hidden');

    // Calculate the min and max dates for the delivery date input
    var today = new Date();
    var tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);

    var threeWeeksFromNow = new Date(today);
    threeWeeksFromNow.setDate(today.getDate() + 21);

    var formattedTomorrow = tomorrow.toISOString().split('T')[0];
    var formattedThreeWeeksFromNow = threeWeeksFromNow.toISOString().split('T')[0];

    var deliveryDateInput = document.getElementById('editDeliveryDate');
    deliveryDateInput.setAttribute('min', formattedTomorrow);
    deliveryDateInput.setAttribute('max', formattedThreeWeeksFromNow);

    var editMessage = document.getElementById('editMessage');
    var charCount = document.getElementById('charCount');
    
    // Update the character count when the modal is opened
    charCount.textContent = 'Note: In English Only - ' + editMessage.value.length + '/50 characters used';

    // Add event listener to update the character count as the user types
    editMessage.addEventListener('input', function() {
        charCount.textContent = 'Note: In English Only - ' + editMessage.value.length + '/50 characters used';
    });

    document.querySelectorAll('input[name="timetable"]').forEach((radio) => {
    radio.addEventListener('change', function() {
        document.getElementById('editDeliveryTime').value = this.value;
        });
    });

    // Set the radio button to match the current delivery time
    document.querySelectorAll('input[name="timetable"]').forEach((radio) => {
        if (radio.value === cart.deltime) {
            radio.checked = true;
            document.getElementById('editDeliveryTime').value = radio.value;
        }
    });

}

function closeModal() {
    document.getElementById('editOrderModal').classList.add('hidden');
}

document.getElementById('editOrderForm').addEventListener('submit', function(event) {
    var form = this;
    var url = form.action;
    var formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', 'Cart updated successfully');
            closeModal();
        } else {
            showAlert('danger', 'Error updating cart');
        }
    })
    .catch(error => {
        showAlert('danger', 'Error updating cart');
        console.error('Error updating cart', error);
    });
});


</script>

@endsection
</x-app-layout>