<div class="flex-1">
<div class="hidden lg:block">
<h1 class="hidden lg:block text-2xl text-gray-600 leading-tight pl-10">Selected Filters</h1>
<div class="grid grid-cols-4 gap-0 pl-10">
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Price:</h2>
        <ul>
            @if(is_array($selected['prices']))
                @foreach($selected['prices'] as $price)
                    <li class="font-semibold text-orange-500">{{ $price }}</li>
                @endforeach
            @else
                <li class="font-semibold text-orange-500">{{ $selected['prices'] }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Category:</h2>
        <ul>
            @if(is_array($selected['categories']))
                @foreach($selected['categories'] as $categoryId)
                    @php
                        $category = \App\Models\Category::find($categoryId);
                    @endphp
                    <li class="font-semibold text-orange-500">{{ $category->name }}</li>
                @endforeach
            @else
                @php
                    $category = \App\Models\Category::find($selected['categories']);
                @endphp
                <li class="font-semibold text-orange-500">{{ $category->name }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Flavour:</h2>
        <ul>
            @if(is_array($selected['flavours']))
                @foreach($selected['flavours'] as $flavourId)
                    @php
                        $flavour = \App\Models\Flavour::find($flavourId);
                    @endphp
                    <li class="font-semibold text-orange-500">{{ $flavour->name }}</li>
                @endforeach
            @else
                @php
                    $flavour = \App\Models\Flavour::find($selected['flavours']);
                @endphp
                <li class="font-semibold text-orange-500">{{ $flavour->name }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Bakery:</h2>
        <ul>
            @if(is_array($selected['bakeries']))
                @foreach($selected['bakeries'] as $bakeryId)
                    @php
                        $bakery = \App\Models\Bakery::find($bakeryId);
                    @endphp
                    <li class="font-semibold text-orange-500">{{ $bakery->name }}</li>
                @endforeach
            @else
                @php
                    $bakery = \App\Models\Bakery::find($selected['bakeries']);
                @endphp
                <li class="font-semibold text-orange-500">{{ $bakery->name }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Location:</h2>
        <ul>
            @if(is_array($selected['locations']))
                @foreach($selected['locations'] as $bakeryId)
                    @php
                        $bakery = \App\Models\Bakery::find($bakeryId);
                    @endphp
                    <li class="font-semibold text-orange-500">{{ $bakery->location }}</li>
                @endforeach
            @else
                @php
                    $bakery = \App\Models\Bakery::find($selected['locations']);
                @endphp
                <li class="font-semibold text-orange-500">{{ $bakery->location }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Lead Time:</h2>
        <ul>
            @if(is_array($selected['preptimes']))
                @foreach($selected['preptimes'] as $preptime)
                    <li class="font-semibold text-orange-500">{{ $preptime }}</li>
                @endforeach
            @else
                <li class="font-semibold text-orange-500">{{ $selected['preptimes'] }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Rating:</h2>
        <ul>
            @if(is_array($selected['averageRatings']))
                @foreach($selected['averageRatings'] as $averageRating)
                    <li class="font-semibold text-orange-500">{{ $averageRating }}</li>
                @endforeach
            @else
                <li class="font-semibold text-orange-500">{{ $selected['averageRatings'] }}</li>
            @endif
        </ul>
    </div>
    <div class="hidden lg:block">
        <h2 class="text-lg text-gray-600 leading-tight"><i class="fa-regular fa-circle-check"></i>&nbsp;Selected Cake Size:</h2>
        <ul>
            @if(is_array($selected['sizes']))
                @foreach($selected['sizes'] as $size)
                    <li class="font-semibold text-orange-500">{{ $size }}</li>
                @endforeach
            @else
                <li class="font-semibold text-orange-500">{{ $selected['sizes'] }}</li>
            @endif
        </ul>
    </div>
</div>

<div>
    <div class="mb-4">
        <label for="sort" class="text-lg mb-1">Sort by:</label>
        <div class="flex">
        <select id="sort" name="sort" wire:model="sortBy" class="form-select">
            <option value="latest">Latest</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="name_asc">Name: A to Z</option>
            <option value="name_desc">Name: Z to A</option>
            <option value="rating">Rating</option>
        </select>&nbsp;&nbsp;&nbsp;
        <button wire:click="applySort" class="inline-flex rounded-md items-center px-7 py-0.5 text-lg hover:text-black bg-amber-400 hover:bg-orange-500 hover:text-white active:bg-amber-500">
            Sort
        </button>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4">
        @foreach($this->cakes() as $cake)
            <div class="w-3/3 p-3 hover:shadow-lg hover:bg-white rounded-lg hover:text-orange-500">
                <div class="rounded-md">
                    <a href="/allproducts/{{ $cake->id }}">
                        <img src="{{ asset($cake->photo) }}" alt="Cake Image" class="min-w-40 min-h-40 object-cover rounded-md">
                    </a>
                    <div class="mt-3">
                    <a href="/allproducts/{{ $cake->id }}" class="text-2xl text-black font-bold">{{ $cake->name }}</a>
                    <p>by {{ $cake->bakery->name }}</p>
                    @if($cake->reviews->avg('rating'))
                    <div class="flex items-center h-0">
                        <svg class="w-4 h-4 text-yellow-300 me-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                        </svg>
                        <p class="ms-2 text-sm font-bold text-gray-900 pt-3">{{ number_format($cake->reviews->avg('rating'), 1) }}</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <a href="/allproducts/{{ $cake->id }}" class="text-sm font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">{{ $cake->reviews->count() }} reviews</a>
                    </div>
                    @else
                    <div class="flex items-center h-0">
                    <a href="/allproducts/{{ $cake->id }}" class="text-sm font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">No ratings yet</a>
                    </div>
                    @endif
                    </div>
                    @if($cake->original_price && $cake->price < $cake->original_price)
                        <div class="flex">
                            <h5 class="mt-3">RM <span style="text-decoration: line-through;">{{ $cake->original_price }}</span></h5>&nbsp;&nbsp;
                            <h5 class="mt-3"><span style="color: red;">{{ $cake->price }}</span></h5>
                        </div>
                    @else
                        <h5 class="mt-3">RM {{ $cake->price }}</h5>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>


</div>

<div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">

<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-3">
    @foreach($this->cakes as $cake)
        <div class="w-3/3 p-3 hover:shadow-lg hover:bg-white rounded-lg hover:text-orange-500">
            <div class="rounded-md">
                <a href="/allproducts/{{ $cake->id }}"><img src="{{ asset($cake->photo) }}" alt="Cake Image" class="min-w-32 min-h-32 object-cover rounded-md"></a>
                <div class="mt-3">
                    <a href="/allproducts/{{ $cake->id }}" class="text-xl text-black font-bold">{{ $cake->name }}</a>
                    <p>by {{ $cake->bakery->name }}</p>
                    @if($cake->reviews->avg('rating'))
                    <div class="flex items-center h-0">
                        <svg class="w-4 h-4 text-yellow-300 me-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                        </svg>
                        <p class="ms-2 text-xs font-bold text-gray-900 pt-3">{{ number_format($cake->reviews->avg('rating'), 1) }}</p>
                        <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                        <a href="/allproducts/{{ $cake->id }}" class="text-xs font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">{{ $cake->reviews->count() }} reviews</a>
                    </div>
                    @else
                    <div class="flex items-center h-0">
                    <a href="/allproducts/{{ $cake->id }}" class="text-sm font-medium text-gray-900 hover:text-orange-500 underline hover:no-underline">No ratings yet</a>
                    </div>
                    @endif
                </div>
                @if($cake->original_price && $cake->price < $cake->original_price)
                <h5 class="mt-3"><span style="text-decoration: line-through;">RM {{ $cake->original_price }}</h5>
                <h5 class="mt-1"><span style="color: red;">RM {{ $cake->price }}</span></h5>
                @else
                <h5 class="mt-3">RM {{ number_format($cake->price, 2) }}</h5>
                @endif
                <p class="mt-3">{{ $cake->category->name }}</p>
            </div>
        </div>
    @endforeach
</div>
</div>


</div>



