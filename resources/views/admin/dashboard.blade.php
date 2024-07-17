@extends('layouts.admin')
@section('content')

<div class="banner">
    <img src="/img/admincover.svg" class="banner-image" alt="Banner Image">
    <div class="banner-ad text-4xl sm:text-5xl md:text-6xl">
        Admin Dashboard
    </div>
</div>
<h1 class="text-center pt-10 font-semibold text-2xl lg:text-4xl text-gray-800 leading-tight">
    {{ __("$pendingEnquiryCount enquiries to be reviewed") }} &nbsp;&nbsp; {{ __('|') }} &nbsp;&nbsp; {{ __("$applicationCount pending applications") }}
</h1>

<div class="container text-center mt-24 mb-20">
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.userlist') }}" class="text-decoration-none text-dark">
                <img src="/img/usericon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">User Management</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.bakerylist') }}" class="text-decoration-none text-dark">
                <img src="/img/bakeryicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Bakery Management</h4>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.enquirylist') }}" class="text-decoration-none text-dark">
                <img src="/img/enquirymicon.png">
                <div class="flex items-center justify-center">
                    @if($availableEnquiry)
                        <i class="fa-solid fa-circle fa-bounce" style="color: #ff2600;"></i>
                    @endif
                    <h4 class="font-bold text-3xl text-gray-800 leading-tight ml-2">Enquiry Management</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.bakeryApplicationList') }}" class="text-decoration-none text-dark">
                <img src="/img/bapplicationicon.png">
                <div class="flex items-center justify-center">
                    @if($availableApplication)
                        <i class="fa-solid fa-circle fa-bounce" style="color: #ff2600;"></i>
                    @endif
                    <h4 class="font-bold text-3xl text-gray-800 leading-tight ml-2">Bakery Application</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('corporateOrders.list') }}" class="text-decoration-none text-dark">
                <img src="/img/corporateicon.png">
                <div class="flex items-center justify-center">
                    @if($availableCorpOrder)
                        <i class="fa-solid fa-circle fa-bounce" style="color: #ff2600;"></i>
                    @endif
                    <h4 class="font-bold text-3xl text-gray-800 leading-tight ml-2">Corporate Order</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark">
                <img src="/img/settingicon.png">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Settings</h4>
            </a>
        </div>
    </div>
</div>
@endsection

