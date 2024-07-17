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
                    <a href="/bakery/listproduct" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp All Products</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="mt-9 p-4 mx-5 bg-green-500 text-white rounded-md">
        {{ session('success') }}
    </div>
@endif

@if(session('mssg'))
    <div class="mt-9 p-4 mx-5 bg-green-500 text-white rounded-md">
        {{ session('mssg') }}
    </div>
@endif

<div class="flex justify-between">
    <h1 class="text-left pt-8 pl-11 font-semibold text-3xl sm:text-4xl text-gray-800 leading-tight">
      {{ __('All Products') }}
    </h1>
    <a href="{{ route('bakery.manageCategories') }}" class="text-amber-500 font-bold hover:text-orange-500 text-lg sm:text-2xl pt-9 pr-11"><i class="fa-solid fa-pen-to-square"></i> Manage Category</a>
</div>

<!-- Search Form -->
<div class="container mx-auto pt-8">
    <form action="{{ route('bakery.listproduct') }}" method="GET" class="mb-6">
        <div class="flex items-center">
            <input type="text" name="search" id="search" placeholder="Search cake" value="{{ request('search') }}" class="border border-gray-300 rounded-md py-2 px-4 w-full">
            <button type="submit" class="ml-2 px-4 py-2 bg-amber-400 text-white font-bold rounded-md">Search</button>
        </div>
    </form>
</div>


<div class="container mx-auto py-8">
@if($cakesByCategory->isEmpty())
    <div class="text-center py-4">
        <p class="text-xl text-gray-600">Opps! Your menu is still empty.</p>
    </div>
    <div class="mt-4 mb-2 text-center">
    <a href="{{ route('bakery.createproduct') }}" class="px-4 py-3 bg-orange-500 hover:bg-amber-500 text-white text-xl font-bold rounded-md"><i class="fa-solid fa-plus"></i> &nbsp;Add New Menu Now!</a>
    </div>
@else
  @foreach($cakesByCategory as $categoryName => $cakes)
    <div class="mb-4">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-text hover:text-orange-500 active:text-amber-400 cursor-pointer" data-category="{{ $categoryName }}">
          <span class="ml-2 inline-flex">
          <i class="fa-solid fa-chevron-right"></i>
          </span>  
          &nbsp;{{ $categoryName }}
        </h2>
        <a href="{{ route('bakery.createproduct') }}" class="text-orange-500 font-bold hover:text-amber-500 pr-2 pb-2">Add Cake</a>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4 hidden overflow-hidden" data-content="{{ $categoryName }}">
        @foreach($cakes as $cake)
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg">
            <img src="{{ asset($cake->photo) }}" alt="Cake Image" class="w-full h-40 object-cover rounded-md mb-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">{{ $cake->name }}</h3>
                <a href="{{ route('bakery.viewproduct', $cake->id) }}" class="text-amber-500 font-bold hover:text-orange-500 pb-1">Show</a>
            </div>
            <p class="text-amber-500 font-bold text-lg">RM {{ number_format($cake->price, 2) }}</p>
            <label class="inline-flex items-center me-5 cursor-pointer">
                <input type="checkbox" value="1" class="sr-only peer product-visibility-checkbox" data-id="{{ $cake->id }}" {{ $cake->visible ? 'checked' : '' }}>
                <input type="hidden" name="availability" id="availabilityHidden" value="1"> <!-- Hidden field for unchecked state -->
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-400"></div>
            </label>
        </div>
        @endforeach
      </div>
    </div>
    <div class="border-t border-gray-300 pb-4"></div>
  @endforeach
@endif
</div>

<script>
  const categoryHeaders = document.querySelectorAll('.cursor-pointer');

  categoryHeaders.forEach((header) => {
    header.addEventListener('click', function() {
      const categoryName = this.dataset.category;
      const content = document.querySelector(`[data-content="${categoryName}"]`);
      const arrow = this.querySelector('i');

      content.classList.toggle('hidden');
      arrow.classList.toggle('fa-chevron-right'); // Toggle class for arrow icon
      arrow.classList.toggle('fa-chevron-down'); // Toggle class for arrow icon
    });
  });

  document.querySelectorAll('.product-visibility-checkbox').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
          const productId = this.dataset.id;
          const visible = this.checked ? 1 : 0;

          fetch(`/bakery/update-visibility/${productId}`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Ensure you have CSRF token meta tag in your HTML head
              },
              body: JSON.stringify({ visible: visible })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  console.log('Visibility updated successfully');
              } else {
                  console.error('Error updating visibility');
              }
          });
      });
  });

</script>

<div class="bg-transparent accordion max-w-7xl mx-auto sm:px-6 lg:px-8 pb-5" id="accordionExample">
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

@endsection
