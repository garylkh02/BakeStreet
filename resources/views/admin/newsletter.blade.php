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
                    <a href="/admin/newsletter" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Send Newsletter</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="space-x-8 sm:-my-px sm:ms-10 sm:flex mt-5 mb-4">
    <h1 class="text-left pl-2 font-semibold text-4xl text-gray-800 leading-tight">
        {{ __('Send Newsletter') }}
    </h1>
</div>
<div class="container">
    <form action="{{ route('admin.newsletter.send') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Title:</label>
            <input type="text" name="title" id="title" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
        </div>

        <div class="form-group">
            <label for="content" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Content:</label>
            <textarea type="text" name="content" id="content" class="block w-96 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required></textarea>
        </div>

        <div class="form-group">
        <label for="image" class="block mb-2 text-sm font-bold text-xl text-gray-900 pt-4">Image:</label>
        <input class="form-control block" name="image" type="file" id="image">
        </div>
<br>
        <div class="pt-3">
            <button type="submit" class="bg-orange-500 hover:bg-amber-500 active:bg-orange-500 text-white text-xl font-bold py-2.5 px-20 rounded w-96">
            Send Newsletter
            </button>
        </div>
    </form>
</div>
<br>
<br>
@endsection

