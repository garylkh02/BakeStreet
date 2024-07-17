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
                    <a href="/admin/bakeryenquiry" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Enquiry</a>
                </li>
            </ol>
        </nav>
    </div>
</div>


<div class="space-x-8 -my-px ms-10 flex mt-5 mb-1 pl-2">
    @if (Auth::user()->usertype == 'admin')
        <x-nav-link href="{{ route('admin.userenquiry') }}" :active="request()->routeIs('admin.userenquiry')" class="hover:text-orange-500 active:text-amber-400">
        <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{ __('User') }}
        </x-nav-link> 

        <x-nav-link href="{{ route('admin.bakeryenquiry') }}" 
        class="text-orange-500 hover:text-red-600 active:text-amber-500 hover:border-b-4 hover:border-red-500 active:border-b-4 active:border-red-200 bg-amber-100 rounded-lg pt-3 pb-3 px-3 text-xl">
        <i class="fa-solid fa-cake-candles"></i>&nbsp;&nbsp;{{ __('Bakery') }}
        </x-nav-link>

        <!-- Search Bar -->
        <div class="searchbar hidden md:flex">
        <form action="{{ route('admin.benquirysearch') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search by email" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
        </form>
        </div>
    @endif
</div>

<h1 class="text-left pt-8 pl-14 font-semibold text-4xl text-gray-800 leading-tight">
  {{ __('Bakery Enquiry List') }}
</h1>

<div class="w-full px-12 pt-3 pb-10">
<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-100 border-amber-500 rounded-xl">
        <thead>
            <tr class="w-full border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Enquiry ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Submitted Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiry as $enquiry)
            <tr class="w-full border-gray-300 border-b">
                <td class="px-6 py-3 whitespace-nowrap"># {{ $enquiry->id }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $enquiry->name }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $enquiry->phone }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $enquiry->email }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $enquiry->created_at->format('d / m / Y') }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ ucfirst($enquiry->status) }}
                    @if($enquiry->status === 'to be reviewed')
                        &nbsp;<i class="fa-solid fa-circle fa-bounce fa-xs" style="color: #ff2600;"></i>
                    @endif</td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('admin.showbakeryen', ['id' => $enquiry->id, 'type' =>  'bakery']) }}" class="text-orange-500 hover:text-orange-500 text-lg">Show</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>



@endsection
