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
                @if(session('previous_page') == 'bakeryproducts')
                <li class="flex items-center">
                    <a href="/bakery/listproduct" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp All Products &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/bakery/listproduct" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Manage Categories</a>
                </li>
                @else
                <li class="flex items-center">
                    <a href="/bakery/listproduct" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Manage Categories</a>
                </li>
                @endif
            </ol>
        </nav>
    </div>
</div>
<div class="banner">
    <img src="/img/catmanage.svg" class="banner-image" alt="Banner Image">
</div>
<h1 class="text-left pt-8 pl-11 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Manage Categories') }}
</h1>

<div class="container mx-auto py-8">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500 text-white rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to Add New Category -->
    <form action="{{ route('bakery.addCategory') }}" method="POST" class="mb-6">
        @csrf
        <div class="mb-4">
            <label for="category_name" class="block text-lg font-medium text-gray-700">New Category Name</label>
            <input type="text" name="category_name" id="category_name" required class="mt-1 block w-96 border border-gray-300 rounded-md shadow-sm">
        </div>
        <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-amber-400 font-bold text-white rounded-md">Add Category</button>
    </form>

    <!-- Display Current Categories -->
    <h2 class="text-xl font-bold mb-2">Current Categories</h2>
    <ul>
        @foreach($categories as $category)
            <li class="mb-2">- {{ $category->name }}</li>
        @endforeach
    </ul>
    <div class="mt-14 mb-2 text-center">
        <a href="{{ route('bakery.listproduct') }}" class="px-4 py-3 bg-green-500 hover:bg-green-600 font-bold text-lg text-white rounded-md hover:bg-blue-700"><i class="fa-solid fa-chevron-left"></i> &nbsp;Back to Menu</a>
    </div>
</div>
@endsection
