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
                    <a href="/admin/bloglist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Cake Blog List &nbsp&nbsp </a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('admin.viewblog', $post->slug) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $post->title }}</a>
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
    <br>
    <br>
    <div class="text-center mt-4">
        <a href="{{ route('admin.blog.edit', $post->id) }}" class="px-9 py-2 bg-green-500 hover:bg-green-700 text-white rounded-md"><i class="fa-solid fa-edit"></i> &nbsp;Edit Blog</a>
    </div>
    <br>
    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="mb-4 text-center">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-7 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md"><i class="fa-solid fa-trash"></i> &nbspDelete Blog</button>
    </form>
</div>
<br>
<br>

@endsection
