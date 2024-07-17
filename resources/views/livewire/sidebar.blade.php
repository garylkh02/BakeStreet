<div class="max-w-screen-sm">
    <h1 class="text-2xl text-gray-800 leading-tight">
        {{ __('Filters') }} &nbsp;&nbsp;
        <button wire:click="clearFilters" class="inline-flex bg-amber-400 items-center px-2.5 py-2 text-lg leading-4 font-medium rounded-md text-gray-800 hover:text-black hover:bg-amber-400 focus:outline-none focus:bg-amber-400 active:bg-amber-500 transition ease-in-out duration-150">Clear&nbsp;<i class="fa-solid fa-rotate-right fa-spin"></i></button>
    </h1>
    <h1 class="text-xl text-gray-800 leading-tight py-2 pb-0">
        {{ __('Price Range') }}
    </h1>
    
    <ul class="pl-0">
        @foreach($prices as $price)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $price['name'] }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$price['name']}}' , type: 'price' })" 
                    class="inline-flex rounded-md items-center px-2.5 py-0.5 text-md hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $price['name'] }} ({{ $price['products_count'] }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    
    <h1 class="text-xl text-gray-800 leading-tight pb-0">Categories</h1>
    <ul class="pl-0">
        @foreach($categories as $category)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $category->id }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$category['id']}}', type: 'category'})" 
                    class="inline-flex rounded-md items-center px-2.5 py-0.5 text-md hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $category->name }} ({{ $category->cakes_count }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Flavours</h1>
    <ul class="pl-0">
        @foreach($flavours as $flavour)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $flavour->id }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$flavour['id']}}', type: 'flavour'})" 
                    class="inline-flex rounded-md items-center px-2.5 py-0.5 text-md hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $flavour->name }} ({{ $flavour->cakes_count }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Bakeries</h1>
    <ul class="pl-0">
        @foreach($bakeries as $bakery)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $bakery->id }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$bakery['id']}}', type: 'bakery'})" 
                    class="inline-flex rounded-md items-center px-2.5 py-0.5 text-md hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $bakery->name }} ({{ $bakery->cakes_count }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Location</h1>
    <ul class="pl-0">
        @foreach($bakeries as $bakery)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $bakery->id }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$bakery['id']}}', type: 'location'})" 
                    class="inline-flex rounded-md items-center text-md px-2.5 py-0.5 hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $bakery->location }} ({{ $bakery->cakes_count }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Lead Time</h1>
    <ul class="pl-0">
        @foreach($preptimes as $preptime)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $preptime['name'] }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$preptime['name']}}', type: 'preptime'})" 
                    class="inline-flex rounded-md items-center text-md px-2.5 py-0.5 hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $preptime['name'] }} ({{ $preptime['products_count'] }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Review Ratings</h1>
    <ul class="pl-0">
        @foreach($averageRatings as $averageRating)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $averageRating['name'] }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$averageRating['name']}}', type: 'averageRating'})" 
                    class="inline-flex rounded-md items-center text-md px-2.5 py-0.5 hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $averageRating['name'] }} ({{ $averageRating['products_count'] }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>

    <h1 class="text-xl text-gray-800 leading-tight pb-0">Cake Size</h1>
    <ul class="pl-0">
        @foreach($sizes as $size)
            <li>
                <label class="py-1">
                <button 
                    value="{{ $size['name'] }}" 
                    wire:click="$dispatch('update_selected', {selected : '{{$size['name']}}', type: 'size'})" 
                    class="inline-flex rounded-md items-center text-md px-2.5 py-0.5 hover:text-black hover:bg-amber-400 active:bg-amber-500">
                    {{ $size['name'] }} ({{ $size['products_count'] }})
                </button>
                </label>
            </li>
        @endforeach
    </ul>
</div>




