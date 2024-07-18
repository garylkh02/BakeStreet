@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home</a>
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                </li>
                <li class="flex items-center">
                    <a href="/admin/enquirylist" class="text-gray-700 hover:text-gray-900">Enquiry Management</a>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'user')
                        &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                        <a href="{{ route('admin.userenquiry') }}" class="text-gray-700 hover:text-gray-900">User Enquiry</a>
                    @elseif(session('previous_page') == 'bakery')
                        &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                        <a href="{{ route('admin.bakeryenquiry') }}" class="text-gray-700 hover:text-gray-900">Bakery Enquiry</a>
                    @elseif(session('previous_page') == 'search')
                        <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Enquiry Search Results</a>
                    @endif
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'usersearch')
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                    <a href="{{ route('admin.userenquiry') }}" class="text-gray-700 hover:text-gray-900">User Enquiry</a>
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp User Enquiry Search Results</a>
                    @elseif(session('previous_page') == 'bakerysearch')
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                    <a href="{{ route('admin.bakeryenquiry') }}" class="text-gray-700 hover:text-gray-900">Bakery Enquiry</a>
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Enquiry Search Results</a>
                    @endif
                </li>
                <li class="flex items-center">
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                    <a href="" class="text-gray-700 hover:text-gray-900">Enquiry Details for #{{ $enquiry->id }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
@if(session('success'))
<div class="mb-4 p-4 bg-green-500 text-white">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
@endif
<h1 class="text-left pt-8 pl-14 font-semibold text-4xl text-gray-800 leading-tight">
  {{ __('Enquiry Details') }}
</h1>
<div class="container mt-4 mb-14">
    <div class="card">
        <div class="card-header">
            Enquiry ID: # {{ $enquiry->id }}
        </div>
        <div class="card-body">
            @if(session('previous_page') == 'bakery')
            <p><strong>Bakery ID:</strong> {{ $enquiry->bakery_id }}</p>
            <p><strong>Bakery Name:</strong> {{ $enquiry->bakery->name }}</p>
            @endif
            <p><strong>Name:</strong> {{ $enquiry->name }}</p>
            <p><strong>Email:</strong> {{ $enquiry->email }}</p>
            <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
            <p class="text-lg"><strong>Message:</strong> {{ $enquiry->message }}</p>
            <p><strong>Status:</strong> {{ ucfirst($enquiry->status) }}</p>
            <p><strong>Created At:</strong> {{ $enquiry->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $enquiry->updated_at }}</p>
        </div>

        <div class="mt-8 text-center">
        <form action="{{ route('admin.updateEnquiryStatus', ['id' => $enquiry->id, 'type' => $enquiry->type]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col items-center justify-center">
                <div class="mb-4 w-full flex flex-col items-center">
                    <label for="status" class="block text-xl font-bold text-gray-700 text-center mb-2">Update Enquiry Status</label>
                    <select id="status" name="status" class="text-center block w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md rounded-md">
                        <option value="reviewed" {{ $enquiry->status == 'to be reviewed' ? 'selected' : '' }}>To be reviewed</option>    
                        <option value="reviewed" {{ $enquiry->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="solved" {{ $enquiry->status == 'solved' ? 'selected' : '' }}>Solved</option>
                    </select>
                </div>
                <div class="mb-4">
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
                        <i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> &nbsp;Update Status
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
