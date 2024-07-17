@extends ('layouts.bakery')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6"> 
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex flex-wrap">
                <li class="flex items-center">
                    <a href="/bakery/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.listproduct') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp All Products &nbsp&nbsp </a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('bakery.viewproduct', $cake->id) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $cake->name }}</a>
                </li>
                <li class="flex items-center">
                &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="{{ route('bakery.listproduct') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Edit {{ $cake->name }} Details&nbsp&nbsp </a>
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
<div class="wrapper create-cake card mt-5">
    <h1>Edit Cake Details</h1>
    <form action="{{ route('bakery.updateproduct', $cake->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <label for="name">Cake name:</label>
        <input type="text" id="name" name="name" value="{{ $cake->name }}" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>

        <label for="category_id">Cake category:</label>
        <select wire:model="selectedCategory" class="form-control" id="category_id" name="category_id" required>
            <option value="" selected disabled>Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $cake->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="flavour_id">Choose cake flavour:</label>
        <select wire:model="selectedFlavour" class="form-control" id="flavour_id" name="flavour_id" required>
            <option value="" selected disabled>Select Flavour</option>
            @foreach ($flavours as $flavour)
                <option value="{{ $flavour->id }}" {{ $cake->flavour_id == $flavour->id ? 'selected' : '' }}>{{ $flavour->name }}</option>
            @endforeach
            <option value="other">Others</option>
        </select>

        <div id="other_flavour_input" style="display: none;">
            <label for="other_flavour">Enter Other Flavour:</label>
            <input type="text" class="form-control" id="other_flavour" name="other_flavour">
        </div>

        <fieldset>
            <label>Cake Sizes Available:</label>
            @php
                $sizes = json_decode($cake->size, true);
            @endphp
            @foreach (['6inch', '7inch', '8inch', '9inch', '10inch'] as $size)
            <div>
                <input type="checkbox" name="sizes[{{ $size }}][enabled]" value="1" data-size-checkbox {{ isset($sizes[$size]) && $sizes[$size]['enabled'] ? 'checked' : '' }}>{{ $size }}<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="sizes[{{ $size }}][price]" placeholder="Price for {{ $size }}" step="0.50" data-size-price value="{{ isset($sizes[$size]) ? $sizes[$size]['price'] : '' }}">
            </div>
            @endforeach
        </fieldset>

        <label for="preptime">Preparation Time:</label>
        <select class="form-control" id="preptime" name="preptime" required>
            <option value="" selected disabled>Select Time</option>
            @foreach (['5hours', '1day', '2day', '3day'] as $time)
                <option value="{{ $time }}" {{ $cake->preptime == $time ? 'selected' : '' }}>{{ $time }}</option>
            @endforeach
        </select>

        <label class="inline-flex items-center me-5 cursor-pointer">Allow Self Collect?
            <input type="checkbox" value="1" class="sr-only peer" id="selfCollectCheckbox" {{ $cake->selfcollect ? 'checked' : '' }}>
            <input type="hidden" name="selfcollect" id="selfCollectHidden" value="{{ $cake->selfcollect }}">
            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-400"></div>
        </label>

        <label for="name">Occasions:<br>(Select N/A if not applicable)</label>
        <select wire:model="selectedOccasions" class="form-control" id="occasions" name="occasions" required>
            <option value="" selected disabled>Select Occasions</option>
            @foreach (['CNY', 'Christmas', 'HariRaya', 'Deepavali', 'Anniversary', 'MothersDay', 'FathersDay', 'N/A'] as $occ)
                <option value="{{ $occ }}" {{ $cake->occasions == $occ ? 'selected' : '' }}>{{ $occ }}</option>
            @endforeach
        </select>

        <label for="description">Cake Description:</label>
        <textarea id="description" name="description" class="appform-form-control w-96 p-2 border border-gray-300 rounded" rows="4" required>{{ $cake->description }}</textarea>
        <div id="description-char-count" class="text-sm text-gray-500"></div>

        <label for="cakecare">Cake Care Instructions:</label>
        <textarea id="cakecare" name="cakecare" class="appform-form-control w-96 p-2 border border-gray-300 rounded" rows="4" required>{{ $cake->cakecare }}</textarea>
        <div id="cakecare-char-count" class="text-sm text-gray-500"></div>

        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" class="appform-form-control w-96 p-2 border border-gray-300 rounded" rows="4" required>{{ $cake->ingredients }}</textarea>
        <div id="ingredients-char-count" class="text-sm text-gray-500"></div>

        <label for="allergens">Allergens:</label>
        <input type="text" id="allergens" name="allergens" value="{{ $cake->allergens }}" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>

        <label for="items">What's in the box?:</label>
        <input type="text" id="items" name="items" value="{{ $cake->items }}" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>

        <label for="name">Cake Photo:</label>
        <input class="form-control" name="photo" type="file" id="photo" accept="image/*">

        <fieldset>
            <label>Add-ons Available:</label>
            @php
                $addons = json_decode($cake->addons, true);
            @endphp
            @foreach (['candles', 'card', 'cakemessage', 'balloon'] as $addon)
            <div>
                <input type="checkbox" name="addons[{{ $addon }}][enabled]" value="1" {{ isset($addons[$addon]) && $addons[$addon]['enabled'] ? 'checked' : '' }}>{{ ucfirst($addon) }}<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="addons[{{ $addon }}][price]" placeholder="Price for {{ ucfirst($addon) }}" step="0.50" value="{{ isset($addons[$addon]) ? $addons[$addon]['price'] : '' }}">
            </div>
            @endforeach
        </fieldset>

        <label for="original_price">Original Price for 6-Inch:</label>
        <input type="number" min="1" step="any" id="original_price" name="original_price" value="{{ $cake->original_price ?? $cake->price }}" class="appform-form-control w-72 p-2 border border-gray-300 rounded" readonly>

        <label for="discount" class="pb-2">Discount Amount:<br>(Enter amount to discount all sizes)</label>
        <input type="number" min="0" step="any" id="discount" name="discount" value="{{ $cake->discount }}" class="appform-form-control w-72 p-2 border border-gray-300 rounded" data-original-discount="{{ $cake->discount }}">

        @if ($errors->has('discount'))
            <div class="text-red-500 mt-2">{{ $errors->first('discount') }}</div>
        @endif
        <br>
        <input type="submit" class="font-bold rounded-md" value="Update Cake">
    </form>
</div>

<div class="mt-5 mb-14 text-center">
    <a href="{{ route('bakery.viewproduct', $cake->id) }}" class="px-7 py-3 bg-green-500 hover:bg-green-600 font-bold text-lg text-white rounded-md hover:bg-blue-700"><i class="fa-solid fa-chevron-left"></i> &nbsp;Back to Cake Details</a>
</div>
<div class="mt-5 mb-14 text-center">
    <form action="{{ route('bakery.deleteproduct', $cake->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-7 py-2 bg-red-600 hover:bg-red-700 font-bold text-lg text-white rounded-md">
            <i class="fa-solid fa-trash"></i> &nbsp;Delete Cake
        </button>
    </form>
</div>
<script>
    function setupCharacterCount(textareaId, countElementId, maxLength) {
        const textarea = document.getElementById(textareaId);
        const countElement = document.getElementById(countElementId);

        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            const remainingLength = maxLength - currentLength;

            if (remainingLength >= 0) {
                countElement.textContent = remainingLength + ' characters remaining';
            } else {
                this.value = this.value.substring(0, maxLength);
            }
        });
    }

    setupCharacterCount('description', 'description-char-count', 300);
    setupCharacterCount('cakecare', 'cakecare-char-count', 255);
    setupCharacterCount('ingredients', 'ingredients-char-count', 255);

    const checkbox = document.getElementById('selfCollectCheckbox');
    const hiddenInput = document.getElementById('selfCollectHidden');

    checkbox.addEventListener('change', function() {
        hiddenInput.value = this.checked ? '1' : '0';
    });

    document.getElementById('flavour_id').addEventListener('change', function () {
        var otherInput = document.getElementById('other_flavour_input');
        if (this.value === 'other') {
            otherInput.style.display = 'block';
            otherInput.querySelector('input').setAttribute('required', 'required');
        } else {
            otherInput.style.display = 'none';
            otherInput.querySelector('input').removeAttribute('required');
        }
    });

    document.getElementById('photo').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = function() {
                if (img.width !== img.height) {
                    alert('Please upload a square photo.');
                    document.getElementById('photo').value = ''; // Clear the input
                }
            };
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const sizeCheckboxes = document.querySelectorAll('input[data-size-checkbox]');
        const sizePrices = document.querySelectorAll('input[data-size-price]');
        const discountInput = document.getElementById('discount');
        const originalDiscount = parseFloat(discountInput.getAttribute('data-original-discount')) || 0; // Ensure original discount is stored correctly

        // Store original prices and discount
        sizePrices.forEach(priceInput => {
            if (priceInput.value) {
                priceInput.setAttribute('data-original-price', priceInput.value);
            }
        });

        function updatePrices() {
            const newDiscount = parseFloat(discountInput.value) || 0;
            const discountDifference = newDiscount - originalDiscount;

            sizeCheckboxes.forEach((checkbox, index) => {
                const priceInput = sizePrices[index];
                const originalPrice = parseFloat(priceInput.getAttribute('data-original-price')) || 0;

                if (checkbox.checked) {
                    // Adjust the price based on the discount difference
                    let price = originalPrice - discountDifference;
                    if (price < 0) price = 0; // Ensure no negative prices
                    priceInput.value = price.toFixed(2);
                } else {
                    // If size is not enabled, clear the price
                    priceInput.value = '';
                }
            });
        }

        sizeCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (!checkbox.checked) {
                    const priceInput = sizePrices[Array.from(sizeCheckboxes).indexOf(checkbox)];
                    priceInput.setAttribute('data-original-price', ''); // Clear original price when checkbox is unchecked
                }
                updatePrices();
            });
        });

        sizePrices.forEach((priceInput) => {
            priceInput.addEventListener('input', function () {
                const checkbox = sizeCheckboxes[Array.from(sizePrices).indexOf(priceInput)];
                if (checkbox.checked) {
                    // Update the original price when manually changed
                    priceInput.setAttribute('data-original-price', parseFloat(priceInput.value) || 0);
                }
            });
        });

        discountInput.addEventListener('input', updatePrices);
    });
</script>


@endsection
