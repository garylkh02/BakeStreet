@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/admin/bloglist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Cake Blog List</a>
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
<div class="w-full px-10 lg:px-8 flex mt-5 mb-4">
    <h1 class="text-left pl-2 font-semibold text-4xl text-gray-800 leading-tight">
        {{ __('Cake Blog List') }}
    </h1>
</div>

<div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('admin.viewblog', $post->slug) }}">
                        <img class="card-img-top" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ route('admin.viewblog', $post->slug) }}" class="text-gray-900 hover:text-orange-500">{{ $post->title }}</a>
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
