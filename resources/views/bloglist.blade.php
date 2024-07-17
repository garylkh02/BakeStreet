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
                  <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Cake Blog</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
@if(session('success'))
  <div class="mb-0 p-4 bg-green-500 text-white">
      {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="mb-0 p-4 bg-red-500 text-white">
      {{ session('error') }}
  </div>
@endif
<h1 class="text-center pt-2 pb-3 font-semibold text-4xl text-gray-800 leading-tight">
    The Cake Blog
</h1>
<div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <img class="card-img-top" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-orange-500">{{ $post->title }}</a>
                        </h4>
                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $post->created_at->format('F j, Y') }} • {{ $post->read_time }} min read
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $posts->links() }}
    <br>
    <br>
</div>
@endsection
