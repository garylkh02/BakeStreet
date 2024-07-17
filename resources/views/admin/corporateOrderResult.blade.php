@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('corporateOrders.list') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Corporate Order &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Corporate Order Search Results</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <h1 class="text-left pt-9 pb-3 font-semibold text-3xl sm:text-4xl text-gray-800 leading-tight">
    {{ __('Corporate Order Search Results') }}
    </h1>   
    
    <form action="{{ route('corporateOrders.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @if($results->isEmpty())
        <div class="alert alert-warning" role="alert">
        No record found. Try search other corporate order using their email address.
        </div>
    @else
    <div class="w-full px-12 pt-3 pb-10">
    <div class="overflow-x-auto">
    <table class="min-w-full bg-zinc-100 border-amber-500 rounded-xl">
        <thead>
            <tr class="w-full border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Phone No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Message</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr class="w-full border-gray-300 border-b">
                <td class="px-6 py-3">{{ $result->id }}</td>
                <td class="px-6 py-3">{{ $result->name }}</td>
                <td class="px-6 py-3">{{ $result->email }}</td>
                <td class="px-6 py-3">{{ $result->phone }}</td>
                <td class="px-6 py-3">{{ $result->message }}</td>
                <td class="px-6 py-3">{{ $result->location }}</td>
                <td class="px-6 py-3 whitespace-nowrap">
                    {{ ucfirst($result->status) }}
                    @if(in_array($result->status, ['to be reviewed', 'reviewed', 'ready']))
                        &nbsp;<i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                    @endif
                </td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('corporateOrders.show', ['id' => $result->id]) }}" class="text-orange-500 hover:text-red-500 font-bold">Show</a>
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
