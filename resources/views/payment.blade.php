<x-app-layout>
    @section('content')
    <div class="container mx-auto mt-10 mb-20">
        <div class="max-w-2xl mx-auto bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-gray-700 text-center">Payment Information</h2>
            
            <form action="{{ route('order.success', ['orderId' => $orderId]) }}" class="mt-6" onsubmit="return validateForm()">
                @csrf
                <!-- Common Payment Method Selection -->
                <div class="mb-4">
                    <label class="block text-gray-700">Payment Method</label>
                    <ul class="grid w-full gap-6 md:grid-cols-2 mt-2">
                        <li>
                            <input type="radio" id="card" name="paymentMethod" value="card" class="hidden peer" checked onclick="togglePaymentMethod('card')">
                            <label for="card" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                <div class="block">
                                    <div class="d-flex align-items-center">
                                        <img src="/img/visa.png" alt="Visa" class="payment-method w-12 h-4">
                                        &nbsp;
                                        <img src="/img/mastercard.svg" alt="Mastercard" class="w-12 h-7">
                                    </div>
                                    <div class="w-full text-lg font-semibold text-black">Credit / Debit Card</div>
                                    <div class="w-full text-sm">Use your credit or debit card to make a secure payment.</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="applePay" name="paymentMethod" value="applePay" class="hidden peer" onclick="togglePaymentMethod('applePay')">
                            <label for="applePay" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                <div class="block">
                                    <div class="d-flex align-items-center">
                                    <img src="/img/apple.svg" alt="ApplePay" class="w-12 h-12">
                                    </div>
                                    <div class="w-full text-lg font-semibold text-black">Apple Pay</div>
                                    <div class="w-full text-sm">Pay easily using Apple Pay.</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="fpx" name="paymentMethod" value="fpx" class="hidden peer" onclick="togglePaymentMethod('fpx')">
                            <label for="fpx" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                <div class="block">
                                    <div class="d-flex align-items-center">
                                    <img src="/img/fpx.png" alt="FPX" class="w-18 h-8">
                                    </div>
                                    <div class="w-full text-lg font-semibold text-black">FPX Online Banking</div>
                                    <div class="w-full text-sm">Pay via FPX Online Banking for secure transactions.</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="googlePay" name="paymentMethod" value="googlePay" class="hidden peer" onclick="togglePaymentMethod('googlePay')">
                            <label for="googlePay" class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                <div class="block">
                                    <div class="d-flex align-items-center">
                                    <img src="/img/googlepay.png" alt="GooglePay" class="w-17 h-8">
                                    </div>
                                    <div class="w-full text-lg font-semibold text-black">Google Pay</div>
                                    <div class="w-full text-sm">Use Google Pay for quick and secure payments.</div>
                                </div>
                            </label>
                        </li>
                    </ul>
                </div>

                <!-- Credit/Debit Card Form -->
                <div id="cardForm">
                    <div class="mb-2">
                        <label for="cardNumber" class="block text-gray-700">Card Number</label>
                        <input type="text" id="cardNumber" name="cardNumber" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" maxlength="16" placeholder="1234 5678 9012 3456" required oninput="detectCardType()">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="/img/visa.png" id="visaLogo" alt="Visa" class="payment-method opacity-50">
                        &nbsp;
                        <img src="/img/mastercard.svg" id="mastercardLogo" class="w-12 h-12 opacity-50">
                    </div>
                    <div class="mb-4">
                        <label for="expiryDate" class="block text-gray-700">Expiry Date</label>
                        <input type="text" id="expiryDate" name="expiryDate" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" maxlength="6" placeholder="MMYYYY" required>
                    </div>
                    <div class="mb-4">
                        <label for="cvv" class="block text-gray-700">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" maxlength="3" placeholder="123" required>
                    </div>
                    <div class="mb-4">
                        <label for="nameOnCard" class="block text-gray-700">Name on Card</label>
                        <input type="text" id="nameOnCard" name="nameOnCard" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="John Doe" required>
                    </div>
                </div>

                <!-- Apple Pay Info -->
                <div id="applePayForm" class="hidden">
                    <p class="text-gray-600 mb-4">To complete your purchase using Apple Pay, please proceed with the payment on your Apple device.</p>
                </div>

                <!-- Google Pay Info -->
                <div id="googlePayForm" class="hidden">
                    <p class="text-gray-600 mb-4">To complete your purchase using Google Pay, please proceed with the payment on your Google device.</p>
                </div>

                <!-- FPX Info -->
                <div id="fpxForm" class="hidden">
                    <p class="text-gray-600 mb-4">You will be redirected to the FPX payment gateway to complete your purchase.</p>
                </div>

                <button class="w-full bg-orange-500 text-white px-3 py-2 rounded-md font-bold hover:bg-orange-600">Submit Payment</button>
            </form>
        </div>
    </div>

    <script>
        function detectCardType() {
            const cardNumber = document.getElementById('cardNumber').value;
            const visaLogo = document.getElementById('visaLogo');
            const mastercardLogo = document.getElementById('mastercardLogo');

            if (cardNumber.startsWith('4')) {
                visaLogo.classList.remove('opacity-50');
                visaLogo.classList.add('opacity-100');
                mastercardLogo.classList.remove('opacity-100');
                mastercardLogo.classList.add('opacity-50');
            } else if (cardNumber.startsWith('5')) {
                mastercardLogo.classList.remove('opacity-50');
                mastercardLogo.classList.add('opacity-100');
                visaLogo.classList.remove('opacity-100');
                visaLogo.classList.add('opacity-50');
            } else {
                visaLogo.classList.remove('opacity-100');
                visaLogo.classList.add('opacity-50');
                mastercardLogo.classList.remove('opacity-100');
                mastercardLogo.classList.add('opacity-50');
            }
        }

        function validateForm() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            if (paymentMethod === 'card') {
                const cardNumber = document.getElementById('cardNumber').value;
                const expiryDate = document.getElementById('expiryDate').value;
                const cvv = document.getElementById('cvv').value;

                // Validate card number (length, digits only, starts with 4 or 5)
                if (!/^(4|5)\d{15}$/.test(cardNumber)) {
                    alert('Invalid card number. Please enter a 16-digit card number starting with 4 (Visa) or 5 (MasterCard).');
                    return false;
                }

                // Validate expiry date (format MMYYYY and future date)
                if (!/^(0[1-9]|1[0-2])\d{4}$/.test(expiryDate) || !isFutureDate(expiryDate)) {
                    alert('Invalid expiry date. Please enter a valid expiry date in MMYYYY format.');
                    return false;
                }

                // Validate CVV (3 digits)
                if (!/^\d{3}$/.test(cvv)) {
                    alert('Invalid CVV. Please enter a 3-digit CVV.');
                    return false;
                }
            }

            return true;
        }

        function isFutureDate(expiryDate) {
            const month = parseInt(expiryDate.slice(0, 2), 10);
            const year = parseInt(expiryDate.slice(2), 10);
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed
            const currentYear = currentDate.getFullYear();

            return (year > currentYear) || (year === currentYear && month >= currentMonth);
        }

        function togglePaymentMethod(method) {
            // Hide all forms
            document.getElementById('cardForm').classList.add('hidden');
            document.getElementById('applePayForm').classList.add('hidden');
            document.getElementById('googlePayForm').classList.add('hidden');
            document.getElementById('fpxForm').classList.add('hidden');

            const cardFields = document.querySelectorAll('#cardForm input');
            cardFields.forEach(field => field.removeAttribute('required'));

            // Show the selected form
            switch (method) {
                case 'card':
                    document.getElementById('cardForm').classList.remove('hidden');
                    cardFields.forEach(field => field.setAttribute('required', 'required'));
                    break;
                case 'applePay':
                    document.getElementById('applePayForm').classList.remove('hidden');
                    break;
                case 'googlePay':
                    document.getElementById('googlePayForm').classList.remove('hidden');
                    break;
                case 'fpx':
                    document.getElementById('fpxForm').classList.remove('hidden');
                    break;
            }
        }

        // Initialize by showing the default form
        togglePaymentMethod('card');
    </script>

    @endsection
</x-app-layout>
