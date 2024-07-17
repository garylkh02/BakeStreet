@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home</a>
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                </li>
                <li class="flex items-center">
                    <a href="/admin/bakeryapplicationlist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Application List</a>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'usersearch')
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                    <a href="{{ route('admin.userenquiry') }}" class="text-gray-700 hover:text-gray-900">User Enquiry</a>
                    @endif
                </li>
                <li class="flex items-center">
                    &nbsp&nbsp&nbsp<i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>&nbsp&nbsp&nbsp
                    <a href="" class="text-gray-700 hover:text-gray-900">Application Details for #{{ $application->id }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
@endif

<h1 class="text-left pt-8 pl-3 sm:pl-14 font-semibold text-4xl text-gray-800 leading-tight">
  {{ __('Bakery Application Details') }}
</h1>
<div class="container mt-4 mb-16">
    <div class="card pb-4">
        <div class="card-header">
            Application ID: # {{ $application->id }}
        </div>
        <div class="card-body">
            <p><strong>Applicant Name:</strong> {{ $application->name }}</p>
            <p><strong>Email:</strong> {{ $application->email }}</p>
            <p><strong>Phone No.:</strong> {{ $application->phone }}</p>
            <p><strong>Bakery Name:</strong> {{ ucfirst($application->bakery_name) }}</p>
            <p><strong>Bakery Location:</strong> {{ ucfirst($application->bakery_location) }}</p>
            <p><strong>Social Media Profile:</strong> {{ $application->social_media_link }}</p>
            <p><strong>Description:</strong> {{ $application->message }}</p>
            <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
            <p><strong>Applied on:</strong> {{ $application->created_at }}</p>
        </div>

        <div class="mt-8 text-center">
        <form action="{{ route('admin.updateApplicationStatus', ['id' => $application->id, 'type' => $application->type]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col items-center justify-center">
                <div class="mb-4 w-full flex flex-col items-center">
                    <label for="status" class="block text-xl font-bold text-gray-700 text-center mb-2">Update Application Status</label>
                    <select id="status" name="status" class="text-center block w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md rounded-md">
                        <option value="to be reviewed" selected disabled>To be reviewed</option>    
                        <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="mb-4">
                    <button type="submit" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
                        <i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> &nbsp;Update Status
                    </button>
                </div>

                <div class="mb-4">
                    <a href="{{ url('/admin/bakeryapplicationlist') }}" class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                    <i class="fa-solid fa-arrow-left"></i> &nbsp;Back to Application List
                    </a>
                </div>

            </div>
        </form>
        </div>
    </div>
</div>
@endsection
