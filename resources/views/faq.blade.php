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
                  <a href="/allproducts" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Frequently Asked Questions</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __("You've got questions? We've got answers!") }}
</h1>
<div class="accordion max-w-7xl mx-auto sm:px-6 lg:px-8 pb-8 pt-8" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed bg-amber-400 hover:bg-amber-400 active:bg-amber-200 focus:bg-amber-200" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Are all products on Bake Street Halal?
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse focus:bg-amber-200" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>All of our bakers use Halal certified ingredients to bake. </strong> We do have a couple of alcoholic cakes in our marketplace, which we have mentioned that they contain alcohol in the product details.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed bg-amber-400 hover:bg-amber-400 active:bg-amber-200 focus:bg-amber-200" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
      <button class="accordion-button collapsed bg-amber-400 hover:bg-amber-400 active:bg-amber-200 focus:bg-amber-200" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        How do I know if the cakes are free from allergens?
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>All allergens will be displayed on each individual product page. </strong>However, most of our cakes are baked in an environment that is exposed to common allergens such as dairy, nuts, eggs, wheat, etc. Please take precautionary measures to ensure that your recipient is not allergic to the allergens mentioned above before placing an order
      </div>
    </div>
  </div>
</div>
@endsection
</x-app-layout>
