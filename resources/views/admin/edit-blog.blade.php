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
                    <a href="{{ route('admin.viewblog', $post->slug) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp {{ $post->title }} &nbsp&nbsp </a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/admin/blog/edit/{{ $post->id }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Edit Blog</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    Edit Blog: {{ $post->title }}
</h1>
<br>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-gray-700 font-bold mb-2">Slug:</label>
            <input type="text" name="slug" id="slug" value="{{ $post->slug }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold mb-2">Content:</label>
            <textarea name="content" id="content" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $post->content }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold mb-2">Image:</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($post->image)
                <div class="mt-3">
                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded-3" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="px-7 py-2 bg-green-500 hover:bg-green-700 text-white rounded-md"><i class="fa-solid fa-save"></i> &nbsp;Update Blog</button>
        </div>
    </form>
</div>
<br>
<br>
<script>
    function validateForm() {
        const title = document.getElementById('title').value.trim();
        const slug = document.getElementById('slug').value.trim();
        const content = document.getElementById('content').value.trim();

        if (!title || !slug || !content) {
            alert('Please fill out all required fields.');
            return false;
        }
        return true;
    }
</script>
@endsection
