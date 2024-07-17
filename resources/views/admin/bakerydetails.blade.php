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
                    <a href="/admin/bakerylist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery List &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'searchbakery')
                    <a href="" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Bakery Search Results &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @endif
                </li>
                <li class="flex items-center">
                    <a href="{{ route('admin.showBakery', ['id' => $user->id]) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Details</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto p-4">
    <h1 class="text-4xl pt-6 font-semibold text-gray-800 mb-4">Bakery Details</h1>

    <div class="bg-white border border-gray-200 p-4 mb-7 rounded-lg">
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Name</h2>
            <p class="text-lg">{{ $user->name }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Email</h2>
            <p class="text-lg">{{ $user->email }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Phone</h2>
            <p class="text-lg">{{ $user->phone }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Address</h2>
            <p class="text-lg">{{ $user->address }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">User Type</h2>
            <p class="text-lg">{{ ucfirst($user->usertype) }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">Bakery Location</h2>
            <p class="text-lg">{{ $user->bakery->location ?? 'N/A' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">Member Since</h2>
            <p class="text-lg">{{ $user->created_at->format('d / m / Y') }}</p>
        </div>
        <br>
        <div class="mb-4 text-center">
            <a href="{{ route('admin.bakery.edit', $user->id) }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md inline-block">
            <i class="fa-solid fa-pen-to-square"></i> &nbsp;Edit
            </a>
        </div>
    </div>
</div>
@if (session('success'))
    <script>
        window.onload = function() {
            alert("{{ session('success') }}");
        };
    </script>
@endif
@endsection
