<x-app-layout>

@section('content')

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="#" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Search</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
@if($cakes->isEmpty())
    <div class="alert alert-warning" role="alert">
    No record found. Try search other cakes.
    </div>
@else
<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex">
            <div class="px-4">
            <h1 class="font-semibold text-3xl text-gray-800 leading-tight pb-4">
                {{ __('Ding Dong! Are you looking for these?') }}
            </h1>
                <div class="cake-index">
                      <!-- Inject value or data into view and access from the view -->
                      <p class="mssg">{{ session('mssg') }}</p>

                  <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach($cakes as $cake)
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
                            <h5 class="mt-3 text-lg">RM <span style="text-decoration: line-through;">{{ $cake->original_price }}</span></h5>&nbsp;&nbsp;
                            <h5 class="mt-3 text-lg"><span style="color: red;">{{ $cake->price }}</span></h5>
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
        </div>
    </div>
</div>
@endif
</div>

<div class="bg-transparent accordion max-w-7xl mx-auto sm:px-6 lg:px-8" id="accordionExample">
<h2 class="pb-2">Frequently Asked Questions</h2>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed bg-amber-400" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Are all products on Bake Street Halal?
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>All of our bakers use Halal certified ingredients to bake. </strong> We do have a couple of alcoholic cakes in our marketplace, which we have mentioned that they contain alcohol in the product details.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      I received my cake and it looks different from the pictures on the website.
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Sometimes the cake you have received may differ from what was shown on our website.</strong> The photos on display are for illustration purposes, so do take the lighting and photo editing used into consideration. And also, the cakes would not look exactly the same as they are all handmade by our bakers.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>
<div class="readmorebutt max-w-7xl mx-auto sm:px-6 lg:px-8">
<a href="/faq" class="readmore px-3 py-2.5 border leading-4 rounded-md hover:text-amber-600 dark:hover:text-amber-600 dark:focus:text-black focus:text-black focus:outline-none focus:bg-amber-400 dark:focus:bg-amber-400 dark:active:bg-amber-100 active:bg-amber-100 dark:active:text-black active:text-black">Read More</a>
</div>
<br>
@endsection

</x-app-layout>
