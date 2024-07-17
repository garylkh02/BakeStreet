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
                    <a href="/allproducts" class="text-gray-700 hover:text-gray-900"> &nbsp&nbspAll Products</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div>
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
        <div class="flex">
          <div class="w-1/7 hidden lg:block">
              <div class="max-w-60 bg-amber-100 p-3 rounded-lg">
                    @livewire('sidebar')
                </div>
            </div>

            <div class="w-5/6 mx-auto">
            <h1 class="font-semibold text-3xl text-gray-800 leading-tight pb-2 pl-8">
                {{ __('All Products') }}
            </h1>
                <div class="p-4 pt-0">
                    @livewire('products')
                </div>
            </div>
        </div>
    </div>
</div>




<!-- <h1 class="pl-32 pt-10 font-semibold text-3xl text-gray-800 leading-tight">
      {{ __('All Products') }}
</h1>
<div class="wrapper cake-index">
        <p class="mssg">{{ session('mssg') }}</p>

    @foreach($cakes as $cake) 
        <div class="cake-item">
            <img src="/img/cake.png" alt="cake pic">
            <h4><a href="/allproducts/{{ $cake->id }}">{{ $cake->name }}</a></h4>
          
        </div>
    @endforeach
</div> -->

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
