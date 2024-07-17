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
                    @if(session('previous_page') == 'searchuser')
                        <a href="{{ route('admin.userlist') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp User List &nbsp&nbsp</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'searchbakery')
                        <a href="{{ route('admin.bakerylist') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery List &nbsp&nbsp</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @endif
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'searchuser')
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp User Search Results</a>
                    @elseif(session('previous_page') == 'searchbakery')
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Search Results</a>
                    @endif
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <h1 class="text-left pt-9 pb-3 font-semibold text-4xl text-gray-800 leading-tight">
    @if(session('previous_page') == 'searchuser')
    {{ __('User Search Results') }}
    @elseif(session('previous_page') == 'searchbakery')
    {{ __('Bakery Search Results') }}
    @endif
    </h1>   

    @if(session('previous_page') == 'searchuser')
    <form action="{{ route('admin.usersearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @elseif(session('previous_page') == 'searchbakery')
    <form action="{{ route('admin.bakerysearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @endif
    

    @if($results->isEmpty())
        <div class="alert alert-warning" role="alert">
        @if(session('previous_page') == 'searchuser')
        No record found. Try search other users using their email address.
        @elseif(session('previous_page') == 'searchbakery')
        No record found. Try search other bakeries using their email address.
        @endif
            
        </div>
    @else
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
            @foreach($results as $result)
            <tr class="w-full border-gray-300 border-b">
                <td class="px-6 py-3 whitespace-nowrap"># {{ $result->id }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->name }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->email }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                @if(session('previous_page') == 'searchuser')
                <a href="{{ route('admin.showUser', ['id' => $result->id]) }}" class="text-orange-500 hover:text-orange-500">Show</a>
                @elseif(session('previous_page') == 'searchbakery')
                <a href="{{ route('admin.showBakery', ['id' => $result->id]) }}" class="text-orange-500 hover:text-orange-500">Show</a>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
    @endif
</div>

@endsection
