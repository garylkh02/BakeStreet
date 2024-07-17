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
                    <a href="/admin/enquirylist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Enquiry Management &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'usersearch')
                        <a href="{{ route('admin.userenquiry') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp User Enquiry &nbsp&nbsp</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'bakerysearch')
                        <a href="{{ route('admin.bakeryenquiry') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Enquiry &nbsp&nbsp</a>
                        <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @elseif(session('previous_page') == 'search')
                        <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Enquiry Search Results</a>
                    @endif
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'usersearch')
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp User Enquiry Search Results</a>
                    @elseif(session('previous_page') == 'bakerysearch')
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Enquiry Search Results</a>
                    @endif
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <h1 class="text-left pt-9 pb-3 font-semibold text-4xl text-gray-800 leading-tight">
    @if(session('previous_page') == 'usersearch')
    {{ __('User Enquiry Search Results') }}
    @elseif(session('previous_page') == 'bakerysearch')
    {{ __('Bakery Enquiry Search Results') }}
    @elseif(session('previous_page') == 'search')
    {{ __('Enquiry Search Results') }}
    @endif
    </h1>   
    @if(session('previous_page') == 'usersearch')
    <form action="{{ route('admin.uenquirysearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @elseif(session('previous_page') == 'bakerysearch')
    <form action="{{ route('admin.benquirysearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @elseif(session('previous_page') == 'search')
    <form action="{{ route('admin.enquirysearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email address" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @endif
    

    @if($results->isEmpty())
        <div class="alert alert-warning" role="alert">
        @if(session('previous_page') == 'usersearch')
        No record found. Try search other user enquiries using their email address.
        @elseif(session('previous_page') == 'bakerysearch')
        No record found. Try search other bakery enquiries using their email address.
        @elseif(session('previous_page') == 'search')
        No record found. Try search other enquiries using their email address.
        @endif
        </div>
    @else
    <div class="w-full px-12 pt-3 pb-10">
    <table class="min-w-full bg-zinc-100 border-amber-500 rounded-xl">
        <thead>
            <tr class="w-full border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Enquiry ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Phone No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Submitted Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr class="w-full border-gray-300 border-b">
                <td class="px-6 py-3 whitespace-nowrap"># {{ $result->id }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->name }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->phone }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->email }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $result->created_at->format('d / m / Y') }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ ucfirst($result->status) }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                @if(session('previous_page') == 'usersearch')
                <a href="{{ route('admin.showuseren', ['id' => $result->id, 'type' =>  'user']) }}" class="text-orange-500 hover:text-orange-500 text-lg">Show</a>
                @elseif(session('previous_page') == 'bakerysearch')
                <a href="{{ route('admin.showbakeryen', ['id' => $result->id, 'type' =>  'bakery']) }}" class="text-orange-500 hover:text-orange-500 text-lg">Show</a>
                @elseif(session('previous_page') == 'search')
                <a href="{{ route('admin.showenquiry', ['id' => $result->id, 'type' =>  $result->type]) }}" class="text-orange-500 hover:text-orange-500 text-lg">Show</a>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
