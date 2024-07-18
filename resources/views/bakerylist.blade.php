@extends('layouts.app')

@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm md:text-base" aria-label="Breadcrumb">
            <ol class="list-none px-4 md:px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakeries" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Shop by Bakery</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

<h1 class="text-left pt-2 font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
    Bakeries
</h1>

<div class="flex justify-center space-x-2 sm:space-x-4 py-4 text-lg sm:text-2xl">
    @foreach(range('A', 'Z') as $letter)
        <a href="#{{ $letter }}" class="text-orange-500 hover:text-amber-400 font-bold">{{ $letter }}</a>
    @endforeach
</div>

<div class="container mx-auto py-8">
@if($bakeries->isEmpty())
    <div class="text-center py-4">
        <p class="text-2xl text-gray-600 mt-5">Opps! There's no bakery right now.. &nbsp;<i class="fa-regular fa-face-sad-tear fa-xl"></i></p>
    </div>
@else
@foreach($bakeries as $bakery)
<div id="{{ substr($bakery->name, 0, 1) }}" class="mb-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-3">
    <h2 class="text-xl sm:text-2xl font-bold text-text hover:text-orange-500 active:text-amber-400 cursor-pointer" data-category="{{ $bakery->id }}">
        <span class="ml-2 inline-flex">
        <i class="fa-solid fa-chevron-right"></i>
        </span>  
        &nbsp;{{ $bakery->name }}
    </h2>
    </div>

    <div class="ml-4 hidden overflow-hidden" data-content="{{ $bakery->id }}">
    <div class="mb-1">
        <div class="flex flex-col md:flex-row justify-between font-medium dark:text-white space-y-2 md:space-y-0">
            <p class="text-lg text-gray-600"><i class="fa-solid fa-star" style="color: #ffaa00;"></i> Average Rating: {{ number_format($bakery->averageRating, 2) }}</p>
            <p class="text-lg text-gray-600"><i class="fa-solid fa-location-dot" style="color: #e32400;"></i> Location: {{ $bakery->location }}</p>
            <p class="text-lg text-gray-600">Joined since: {{ $bakery->user->created_at->format('d F Y') }}</p>
            <a href="{{ route('bakeries.profile', $bakery->id) }}" class="text-orange-500 font-bold text-lg hover:text-red-500">View Bakery</a>
        </div>
    </div>
    </div>
<div class="border-t border-gray-300 pb-4"></div>
@endforeach
@endif
</div>
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
