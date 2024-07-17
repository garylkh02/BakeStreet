@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('corporateOrders.list') }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Corporate Order &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('corporateOrders.show', ['id' => $corporateOrder->id]) }}" class="text-gray-700 hover:text-gray-900"> &nbsp;&nbsp; Corporate Order Details for #{{ $corporateOrder->id }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
@if(session('success'))
    <div class="p-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
@endif

<div class="container mx-auto p-4">
    <h1 class="text-4xl pt-6 font-semibold text-gray-800 mb-4">Corporate Order Details</h1>

    <div class="bg-white border border-gray-200 p-16 py-12 mb-24 rounded-lg">
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Name</h2>
            <p class="text-lg">{{ $corporateOrder->name }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Email</h2>
            <p class="text-lg">{{ $corporateOrder->email }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Phone</h2>
            <p class="text-lg">{{ $corporateOrder->phone }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Location</h2>
            <p class="text-lg">{{ $corporateOrder->location }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Message</h2>
            <p class="text-lg">{{ $corporateOrder->message }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Submitted Date</h2>
            <p class="text-lg">{{ $corporateOrder->created_at->format('d / m / Y') }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Status</h2>
            <p class="text-lg">{{ ucfirst($corporateOrder->status) }}</p>
        </div>
        <br>
        <!-- Display the uploaded image -->
        <div class="mt-6 text-center">
            <h3 class="text-xl font-medium text-gray-900 dark:text-white">Uploaded Cake Photo</h3>
            @if ($corporateOrder->photo)
                <img src="{{ asset($corporateOrder->photo) }}" alt="Cake Photo" class="mx-auto mt-2 w-64 h-auto rounded-lg shadow-md">
            @else
                <p>No photo uploaded.</p>
            @endif
        </div>

        <div class="mt-14 mb-2 text-center">
        <form action="{{ route('corporateOrders.update', $corporateOrder->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="status" class="block text-xl font-bold text-gray-700">Update Order Status</label>
                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md rounded-md">
                    <option value="reviewed" {{ $corporateOrder->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="ready" {{ $corporateOrder->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $corporateOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md"><i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> &nbsp;Update Status</button>
            </div>
        </form>
        </div>

        <div class="container mx-auto my-4 text-center">
        <a href="{{ route('corporateOrders.list') }}" class="px-14 py-2 mb-4 bg-amber-400 hover:bg-orange-500 font-bold text-white rounded-md"><i class="fa-solid fa-chevron-left" style="color: #ffffff;"></i> &nbsp;Back</a>
        </div>
    </div>
</div>
@endsection