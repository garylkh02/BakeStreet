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
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp New Blog Post</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Create a New Blog Post') }}
</h1>
<div class="container">
    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <br>
        <div class="flex justify-center mt-2">
            <button type="submit" class="btn btn-warning">Create Blog Post</button>
        </div>
        <div class="container mx-auto my-4 text-center">
            <a href="{{ route('blog.index') }}" class="px-6 py-2 mb-4 bg-cyan-800 hover:bg-cyan-900 font-semibold text-white rounded-md">View All Post</a>
        </div>
  
    </form>
</div>
<br>
<br>
@endsection
