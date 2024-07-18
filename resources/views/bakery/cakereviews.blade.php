@extends('layouts.bakery')

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
                    <a href="/bakery/reviews" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Reviews & Ratings</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="flex justify-between">
    <h1 class="text-left pt-8 pl-11 font-semibold text-4xl text-gray-800 leading-tight">
      {{ $bakery->name }} - Cake Reviews and Ratings
    </h1>
</div>

<div class="flex justify-center space-x-4 py-4 text-2xl">
    @foreach(range('A', 'Z') as $letter)
        <a href="#{{ $letter }}" class="text-green-700 hover:text-orange-500">{{ $letter }}</a>
    @endforeach
</div>


<div class="container mx-auto py-8">
@if($cakes->isEmpty())
    <div class="text-center py-4">
        <p class="text-2xl text-gray-600 mt-5">Opps! Your menu is empty! &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
    </div>
@else
@foreach($cakes as $cake)
<div id="{{ substr($cake->name, 0, 1) }}" class="mb-4">
    <div class="flex justify-between items-center">
    <h2 class="text-2xl font-bold text-text hover:text-orange-500 active:text-amber-400 cursor-pointer" data-category="{{ $cake->id }}">
        <span class="ml-2 inline-flex">
        <i class="fa-solid fa-chevron-right"></i>
        </span>  
        &nbsp;{{ $cake->name }}
    </h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4 ml-4 hidden overflow-hidden" data-content="{{ $cake->id }}">
    @if(isset($reviews[$cake->id]) && $reviews[$cake->id]->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">There are no reviews yet for this cake.</p>
    @else
    @foreach($reviews[$cake->id] as $review)
    <div class="review mb-4">
        <div class="flex items-center mb-1">
            <div class="font-medium dark:text-white">
                {{ $review->user->name }}
                <time datetime="{{ $review->created_at->format('Y-m-d H:i') }}" class="block text-sm text-gray-500 dark:text-gray-400 pb-2">Reviewed on {{ $review->created_at->format('F d, Y') }}</time>
                <x-star-rating :rating="$review->rating"/>
                <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $review->review }}</p>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    </div>
</div>
<div class="border-t border-gray-300 pb-4"></div>
@endforeach
@endif
</div>
<script>
  const cakeHeaders = document.querySelectorAll('.cursor-pointer');

  cakeHeaders.forEach((header) => {
    header.addEventListener('click', function() {
      const cakeId = this.dataset.category;
      const content = document.querySelector(`[data-content="${cakeId}"]`);
      const arrow = this.querySelector('i');

      content.classList.toggle('hidden');
      arrow.classList.toggle('fa-chevron-right');
      arrow.classList.toggle('fa-chevron-down'); 
    });
  });
</script>

@endsection
