@extends ('layouts.bakery')

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
                    <a href="/bakery/listproduct" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp All Products &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="#" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Add Cake</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="wrapper create-cake card mt-5">
    <h1>New Cake?</h1>
    <form action="/bakery/store" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Bakery ID:</label>
        <input type="text" id="bakery_id" name="bakery_id" value="{{ Auth::user()->bakery->id }}" class="appform-form-control w-28 p-2 border border-gray-300 rounded" readonly>
  
        <label for="name">Cake name:</label>
        <input type="text" id="name" name="name" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>

        <label for="category_id">Choose cake category:</label>
        <select wire:model="selectedCategory" class="form-control" id="category_id" name="category_id" required>
        <option value="" selected disabled>Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="flavour_id">Choose cake flavour:</label>
        <select wire:model="selectedFlavour" class="form-control" id="flavour_id" name="flavour_id" required>
            <option value="" selected disabled>Select Flavour</option>
            @foreach ($flavours as $flavour)
                <option value="{{ $flavour->id }}">{{ $flavour->name }}</option>
            @endforeach
            <option value="other">Others</option>
        </select>

        <div id="other_flavour_input" style="display: none;">
            <label for="other_flavour">Enter Other Flavour:</label>
            <input type="text" class="form-control" id="other_flavour" name="other_flavour">
        </div>

        <fieldset>
            <label>Cake Size Available:</label>
            <div>
                <input type="checkbox" name="sizes[6inch][enabled]" value="1" data-size-checkbox>6-inch<br />
                <input data-size-price type="number" name="sizes[6inch][price]" class="appform-form-control w-60 p-2 border border-gray-300 rounded" placeholder="Price for 6-inch" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="sizes[7inch][enabled]" value="1" data-size-checkbox>7-inch<br />
                <input data-size-price type="number" name="sizes[7inch][price]" class="appform-form-control w-60 p-2 border border-gray-300 rounded" placeholder="Price for 7-inch" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="sizes[8inch][enabled]" value="1" data-size-checkbox>8-inch<br />
                <input data-size-price type="number" name="sizes[8inch][price]" class="appform-form-control w-60 p-2 border border-gray-300 rounded" placeholder="Price for 8-inch" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="sizes[9inch][enabled]" value="1" data-size-checkbox>9-inch<br />
                <input data-size-price type="number" name="sizes[9inch][price]" class="appform-form-control w-60 p-2 border border-gray-300 rounded" placeholder="Price for 9-inch" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="sizes[10inch][enabled]" value="1" data-size-checkbox>10-inch<br />
                <input data-size-price type="number" name="sizes[10inch][price]" class="appform-form-control w-60 p-2 border border-gray-300 rounded" placeholder="Price for 10-inch" step="0.50">
            </div>
        </fieldset>

        <label for="preptime">Preparation Time:</label>
        <select class="form-control" id="preptime" name="preptime" required>
            <option value="" selected disabled>Select Time</option>
            <option value="5hours">5 Hours</option>
            <option value="1day">1 Day</option>
            <option value="2day">2 Days</option>
            <option value="3day">3 Days</option>
        </select>

        <label class="inline-flex items-center me-5 cursor-pointer">Allow Self Collect?
            <input type="checkbox" value="1" class="sr-only peer" id="selfCollectCheckbox" checked>
            <input type="hidden" name="selfcollect" id="selfCollectHidden" value="1"> <!-- Hidden field for unchecked state -->
            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-400"></div>
        </label>

        <label for="name">Occasions:<br>(Enter N/A if not applicable)</label>
        <select wire:model="selectedOccasions" class="form-control" id="occasions" name="occasions" required>
            <option value="" selected disabled>Select Occasions</option>
            <option value="CNY">Chinese New Year</option>
            <option value="Christmas">Christmas</option>
            <option value="HariRaya">Hari Raya</option>
            <option value="Deepavali">Deepavali</option>
            <option value="Anniversary">Anniversary</option>
            <option value="MothersDay">Mother's Day</option>
            <option value="FathersDay">Father's Day</option>
            <option value="N/A">N/A</option>
        </select>

        <label for="description">Cake Description:</label>
<textarea id="description" name="description" class="appform-form-control w-72 p-2 border border-gray-300 rounded" rows="4" required></textarea>
<div id="description-char-count" class="text-sm text-gray-500"></div>

<label for="cakecare">Cake Care Instructions:</label>
<textarea id="cakecare" name="cakecare" class="appform-form-control w-72 p-2 border border-gray-300 rounded" rows="4" required></textarea>
<div id="cakecare-char-count" class="text-sm text-gray-500"></div>

<label for="ingredients">Ingredients:</label>
<textarea id="ingredients" name="ingredients" class="appform-form-control w-72 p-2 border border-gray-300 rounded" rows="4" required></textarea>
<div id="ingredients-char-count" class="text-sm text-gray-500"></div>

        <label for="name">Allergens:</label>
        <input type="text" id="allergens" name="allergens" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>
        <label for="name">What's in the box?:</label>
        <input type="text" id="items" name="items" class="appform-form-control w-72 p-2 border border-gray-300 rounded" required>
        
        <label for="name">Cake Photo:</label>
        <input class="form-control" name="photo" type="file" id="photo" accept="image/*" required>

        <fieldset>
            <label>Add-ons Available:</label>
            <div>
                <input type="checkbox" name="addons[candles][enabled]" value="1">Candles<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="addons[candles][price]" placeholder="Price for Candles" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="addons[card][enabled]" value="1">Birthday Card<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="addons[card][price]" placeholder="Price for Birthday Card" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="addons[cakemessage][enabled]" value="1">Message on Cake<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="addons[cakemessage][price]" placeholder="Price for Message on Cake" step="0.50">
            </div>
            <div>
                <input type="checkbox" name="addons[balloon][enabled]" value="1">Balloon Bouquet<br />
                <input class="appform-form-control w-60 p-2 border border-gray-300 rounded" type="number" name="addons[balloon][price]" placeholder="Price for Balloon Bouquet" step="0.50">
            </div>
        </fieldset>

        <label for="price">Price:</label>
        <input type="number" min="1" step="any" id="price" name="price" class="appform-form-control w-28 p-2 border border-gray-300 rounded">

        <br>
        <input type="submit" value="Add Cake" class="font-bold rounded-md">
    </form>
</div>
<br>
<br>

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
                    document.getElementById('photo').value = ''; 
                }
            };
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('price');
        const sizeCheckboxes = document.querySelectorAll('input[data-size-checkbox]');
        const sizePriceInputs = document.querySelectorAll('input[data-size-price]');
        
        function updatePrice() {
            let minPrice = Infinity;
            sizeCheckboxes.forEach(function(checkbox, index) {
                if (checkbox.checked) {
                    const price = parseFloat(sizePriceInputs[index].value);
                    if (!isNaN(price) && price < minPrice) {
                        minPrice = price;
                    }
                }
            });
            if (minPrice === Infinity) {
                minPrice = '';
            }
            priceInput.value = minPrice;
        }

        sizeCheckboxes.forEach(function(checkbox, index) {
            checkbox.addEventListener('change', updatePrice);
        });

        sizePriceInputs.forEach(function(input) {
            input.addEventListener('input', updatePrice);
        });
    });
</script>
@endsection