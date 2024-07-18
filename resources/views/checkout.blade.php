<x-app-layout>
@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/cart" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Shopping Cart&nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/cart" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Checkout</a>
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
<h1 class="text-center pt-2 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Checkout') }}
    <div id="countdown-timer" class="text-2xl text-orange-500"></div>
</h1>
<br>
<div class="mx-4">
    <h3 class="mb-3 text-lg font-medium text-gray-900 dark:text-white">Choose Your Preferred Delivery Method:</h3>
    <form method="POST" action="{{ route('cart.processCheckout') }}" id="checkout-form">
        @csrf
        <ul class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 w-full">
            <li>
                <input type="radio" id="home-delivery" name="delivery-method" value="delivery" class="hidden peer" required>
                <label for="home-delivery" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" aria-hidden="true" class="bi bi-truck mb-2 text-red-600 w-7 h-7" viewBox="0 0 16 16">
                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                        </svg>
                        <div class="w-full text-lg font-semibold text-black">Home Delivery</div>
                        <div class="w-full text-sm">Choose home delivery if you prefer to have your order brought to your doorstep. It's hassle-free and ensures you receive your order without needing to leave your home.</div>
                    </div>
                </label>
            </li>

            <li>
                <input type="radio" id="self-pickup" name="delivery-method" value="pickup" class="hidden peer" {{ $allSelfCollectable ? '' : 'disabled' }}>
                <label for="self-pickup" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff6600" class="mb-2 w-7 h-7 text-sky-500 bi bi-bag-heart" aria-hidden="true" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1M8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"/>
                        </svg>
                        <div class="w-full text-lg font-semibold text-black">Self Pick-Up</div>
                        <div class="w-full text-sm">Opt for self-pickup if you'd like to collect your order from our location. It's convenient and allows you to get your order at your preferred time.</div>
                    </div>
                </label>
            </li>
        </ul>


    @if (!$allSelfCollectable)
    <p class="ml-1 text-sm text-red-600">Note: Self Pick-Up option is disabled because your cart contains items that are not available for self-collection.</p>
    @endif
    <div class="appform-body pb-0">
    <div id="self-pickup-address" style="display: none;">
        <h5 class="mb-2">Pick-up at our physical store</h5>
        <p class="text-lg">Bake Street<br>No. 5, Jalan Universiti, Bandar Sunway, 47500 Subang Jaya, Selangor.<br>Tel: 03-12345678</p>
    </div>
    <div class="appform-form-group">
        <div class="appform-input-group">
            <input type="text" id="recname" name="recname" placeholder="Recipient's Name" class="appform-form-control w-full border border-gray-300 rounded" required>
        </div>
    </div>
    </div>
    <div class="appform-body pt-0">
    <div id="appform-form">
        <div class="appform-form-group">
            <div class="appform-input-group">
                <input type="text" id="street" name="street" placeholder="Street / Building Name" class="appform-form-control w-full border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="grid w-full gap-2 md:grid-cols-3">
        <div class="appform-form-group">
            <div class="appform-input-group">
                <input type="text" id="postcode" name="postcode" placeholder="Postcode" class="appform-form-control w-full border border-gray-300 rounded" required>
            </div>
        </div>
        <div class="appform-form-group">
            <div class="appform-input-group">
                <input type="text" id="city" name="city" placeholder="City" class="appform-form-control w-full border border-gray-300 rounded" required>
            </div>
        </div>
        <div class="appform-form-group">
            <div class="appform-input-group">
                <input type="tel" id="state" name="state" placeholder="State" class="appform-form-control w-full border border-gray-300 rounded" required>
            </div>
        </div>
        </div>
        <div class="appform-form-group">
            <div class="appform-input-group">
                <textarea id="delivery_instructions" name="delivery_instructions" maxlength="80" placeholder="Delivery Instructions" class="appform-form-control w-full border border-gray-300 rounded"></textarea>
            </div>
        </div>
    </div>

    <div class="appform-form-group">
        <div class="appform-input-group">
            <input type="phone" id="recphone" name="recphone" placeholder="Recipient's Mobile Number" class="appform-form-control w-full border border-gray-300 rounded" required>
        </div>
    </div>
            <div class="d-flex align-items-center">
            <h5 class="mb-2 mt-5">Promo Code / Gift Code</h5> 
            &nbsp;&nbsp;&nbsp;
            <p class="mb-2 mt-5" id="coupon-message"></p>
            </div>
            <div data-mdb-input-init class="form-outline">
                <input type="text" id="coupon_code" name="coupon_code" class="form-control form-control-lg custom-placeholder" placeholder="Enter promo or gift code here"/>
            </div>
            <button type="button" id="check-coupon" class="px-2 mt-3 py-1 w-40 text-white bg-amber-500 border-0 rounded-md focus:outline-none hover:bg-amber-400 text-lg font-semibold">Apply Code</button>&nbsp;
            <button type="button" id="remove-coupon" class="px-2 mt-3 py-1 w-40 text-white bg-red-600 border-0 rounded-md focus:outline-none hover:bg-red-700 text-lg font-semibold">Remove Code &nbsp;<i class="fa-solid fa-xmark"></i></button>
            
            <div class="d-flex justify-content-between align-items-center mb-2 mt-10">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 font-bold">Total Price</h5>
                    <p class="mb-0 ms-1">(incl. VAT)</p>
                </div>
                <h5 class="mb-0 font-bold">RM {{ number_format($totalPrice, 2) }}</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 font-bold" id="disheader"></h5>
                </div>
                <h5 class="mb-0 font-bold" id="discount-amount"></h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 font-bold" id="dfheader">Delivery Fee</h5>
                </div>
                <h5 class="mb-0 font-bold" id="delivery-fee">RM 0.00</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 font-bold" id="taheader">Total Amount Payable</h5>
                </div>
                <h5 class="mb-0 font-bold" id="discounted-price"></h5>
            </div>    
            <div class="d-flex justify-content-center align-items-center">
                <button id="cancel-button" class="px-2 mt-3 mb-10 py-1 w-40 text-white bg-red-600 border-0 rounded-md focus:outline-none hover:bg-red-700 text-lg font-semibold">Cancel Order &nbsp;<i class="fa-solid fa-xmark"></i></button>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="px-2 mt-3 mb-10 py-1 w-40 text-white bg-green-500 border-0 rounded-md focus:outline-none hover:bg-green-600 text-lg font-semibold">Proceed &nbsp;<i class="fa-solid fa-cart-shopping fa-bounce"></i></button>
            </div>
    </div>
</form>
</div>

<div class="container mb-5">
    <h3 class="text-center pt-3">Payment Methods:</h3>
    <div class="d-flex justify-content-center align-items-center">
        <img src="/img/visa.png" alt="Visa" class="payment-method">
        <img src="/img/mastercard.svg" alt="Mastercard" class="payment-method mx-3">
        <img src="/img/fpx.png" alt="FPX" class="payment-method">
        <img src="/img/apple.svg" alt="Apple Pay" class="payment-method mx-3">
        <img src="/img/googlepay.png" alt="Google Pay" class="payment-method">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const homeDeliveryRadio = document.getElementById('home-delivery');
        const selfPickupRadio = document.getElementById('self-pickup');
        const homeDeliveryForm = document.getElementById('appform-form');
        const selfPickupAddress = document.getElementById('self-pickup-address');
        const deliveryFeeElement = document.getElementById('delivery-fee');
        const totalPriceElement = document.getElementById('discounted-price');
        const homeDeliveryFee = 8.00; 
        const selfPickupFee = 0.00;

        const streetInput = document.getElementById('street');
        const postcodeInput = document.getElementById('postcode');
        const cityInput = document.getElementById('city');
        const stateInput = document.getElementById('state');
        const deliveryInstructionInput = document.getElementById('delivery_instructions');

        const shopAddress = {
        street: "No. 5, Jalan Universiti, Bandar Sunway",
        postcode: "47500",
        city: "Subang Jaya",
        state: "Selangor"
        };

        const deliveryInstruction = {
        delivery_instructions: "N/A"
        };

        function updateDeliveryFee() {
            let deliveryFee = 0.00;
            let totalPrice = parseFloat('{{ $totalPrice }}');
            if (totalPrice > 100) {
                deliveryFee = 0.00;
            } else if (homeDeliveryRadio.checked) {
                deliveryFee = homeDeliveryFee;
            } else if (selfPickupRadio.checked) {
                deliveryFee = selfPickupFee;
            }
            deliveryFeeElement.innerText = `RM ${deliveryFee.toFixed(2)}`;
            totalPrice += deliveryFee;
            totalPriceElement.innerText = `RM ${totalPrice.toFixed(2)}`;
        }

        homeDeliveryRadio.addEventListener('change', function () {
            if (homeDeliveryRadio.checked) {
                homeDeliveryForm.style.display = 'block';
                selfPickupAddress.style.display = 'none';
                streetInput.value = '';
                postcodeInput.value = '';
                cityInput.value = '';
                stateInput.value = '';
                deliveryInstructionInput.value = '';
                updateDeliveryFee();
            }
        });

        selfPickupRadio.addEventListener('change', function () {
            if (selfPickupRadio.checked) {
                homeDeliveryForm.style.display = 'none';
                selfPickupAddress.style.display = 'block';
                streetInput.value = shopAddress.street;
                postcodeInput.value = shopAddress.postcode;
                cityInput.value = shopAddress.city;
                stateInput.value = shopAddress.state;
                deliveryInstructionInput.value = deliveryInstruction.delivery_instructions;
                updateDeliveryFee();
            }
        });

        // Initialize the delivery fee based on the default selected delivery method
        updateDeliveryFee();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const homeDeliveryRadio = document.getElementById('home-delivery');
        const selfPickupRadio = document.getElementById('self-pickup');
        const checkCouponButton = document.getElementById('check-coupon');

        checkCouponButton.addEventListener('click', function () {
            const couponCode = document.getElementById('coupon_code').value;
            const deliveryMethod = homeDeliveryRadio.checked ? 'home_delivery' : 'self_pickup';

            if (couponCode === '') {
                alert('Please enter a coupon code.');
                return;
            }

            fetch('{{ route("cart.checkCoupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                    delivery_method: deliveryMethod // Send the delivery method
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('coupon-message').innerHTML = '<i class="fa-regular fa-circle-check" style="color: #48d103;"></i> ' + data.success;
                    document.getElementById('discount-amount').innerText = `${new Intl.NumberFormat('en-MY', { style: 'currency', currency: 'MYR' }).format(data.discountAmount)}`;
                    let deliveryFee = parseFloat(document.getElementById('delivery-fee').innerText.replace('RM ', ''));
                    if (data.couponType === 'free_delivery') {
                    deliveryFee = 0.00;
                    }
                
                    document.getElementById('discounted-price').innerText = `${new Intl.NumberFormat('en-MY', { style: 'currency', currency: 'MYR' }).format(data.discountedPrice + deliveryFee)}`;

                    document.getElementById('taheader').innerText = `Total Amount Payable`;
                    document.getElementById('disheader').innerText = `Discount Amount`;
                    
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while checking the coupon.');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const removeCouponButton = document.getElementById('remove-coupon');

        removeCouponButton.addEventListener('click', function () {
            fetch('{{ route("cart.removeCoupon") }}', {  
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    // No need to send coupon code when removing
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('coupon-message').innerText = ''; // Remove the success message
                    document.getElementById('discount-amount').innerText = 'RM 0.00'; // Reset the discount amount
                    
                    let deliveryFee = parseFloat(document.getElementById('delivery-fee').innerText.replace('RM ', ''));
                
                    document.getElementById('discounted-price').innerText = `${new Intl.NumberFormat('en-MY', { style: 'currency', currency: 'MYR' }).format(data.discountedPrice + deliveryFee)}`;
                    document.getElementById('taheader').innerText = 'Total Amount Payable'; // Reset the total amount payable header
                    document.getElementById('disheader').innerText = 'Discount Amount'; // Reset the discount amount header
                    
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the coupon.');
            });
        });
    });

    // Set the countdown timer (e.g., 10 minutes)
    var totalSeconds = 600; // 600 seconds = 10 minutes

    var timer = setInterval(function() {
    // Calculate remaining minutes and seconds
    var remainingMinutes = Math.floor(totalSeconds / 60);
    var remainingSeconds = totalSeconds % 60;

    // Format the time string with leading zeros for seconds
    var formattedTime = (remainingMinutes < 10 ? + remainingMinutes : remainingMinutes) + " Minutes " +
                        (remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds) + " Seconds ";

    document.getElementById('countdown-timer').innerText = formattedTime + ' Remaining';

    totalSeconds--;

    if (totalSeconds <= 0) {
        clearInterval(timer);
        cancelOrder();
    }
    }, 1000);


    document.getElementById('cancel-button').addEventListener('click', function() {
        cancelOrder();
    });

    function cancelOrder() {
    // Make an AJAX request to cancel the order
    fetch('/cancel-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ orderId: {{ $orderId }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to the cancelled order page
            window.location.href = data.cancelledOrderUrl;
        } else {
            // Optionally, show an error message
            alert('Failed to cancel the order. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
    }

</script>

@endsection
</x-app-layout>
