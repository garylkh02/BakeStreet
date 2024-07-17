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
                    <a href="/admin/bakerylist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery List</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="w-full px-10 lg:px-8 flex mt-5 mb-4">
    <h1 class="text-left pl-2 font-semibold text-4xl text-gray-800 leading-tight">
        {{ __('Bakery List') }}
    </h1>

    <!-- Search Bar -->
    <div class="searchbar pt-2 pr-1 hidden lg:flex">
        <form action="{{ route('admin.bakerysearch') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search by email" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
        </form>
    </div>
</div>

<div class="w-full px-12 pt-3 pb-10">
<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-100 border-amber-500 rounded-xl">
        <thead>
            <tr class="w-full border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">User ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="w-full border-gray-300 border-b">
                <td class="px-6 py-3 whitespace-nowrap"># {{ $user->id }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.showBakery', ['id' => $user->id]) }}" class="text-orange-500 hover:text-orange-500">Show</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>



@endsection
