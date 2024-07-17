@extends('layouts.app')

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
                  <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Cake Blog &nbsp&nbsp</a>
                  <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                  <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $post->title }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ $post->title }}
</h1>
<br>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-center">
        <img class="img-fluid rounded-xl w-3/6 h-auto" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
    </div>
    <div class="mt-4 text-center text-lg">
        <p>{{ $post->content }}</p>
    </div>
    <div class="text-muted text-center mt-4">
        Published on {{ $post->created_at->format('F j, Y') }}
    </div>
</div>
<br>
<br>

@endsection
