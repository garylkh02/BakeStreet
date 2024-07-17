<x-app-layout>
@section('content')

@if(session('success'))
    <div class="mb-0 p-4 bg-green-500 text-white">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-0 p-4 bg-red-500 text-white">
        {{ session('error') }}
    </div>
@endif

<div class="banner">
    <img src="/img/corporateorder.jpg" class="banner-image w-full" alt="Banner Image">
</div>
<div class="py-4 pb-0">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-4 sm:px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('corporateOrder') }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Corporate Order</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<h1 class="text-center pt-3 font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
    {{ __('Corporate Order Inquiry Form') }}
</h1>

<div class="mx-24 applicationform">
    <p class="pt-5 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        Corporate gifting is a token of appreciation to customers, employees, prospective clients, or partners for the long-term support and cooperation. 
    </p>
    <p class="pt-2 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        Bake Street would like to be part of your plan. A huge variety of sweet treats and cakes that are perfectly designated for corporate events such as soft launch, festive gifting, and staff appreciation. 
    </p>
    <p class="pt-2 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        For further inquiry regarding corporate orders or bulk orders please contact us through the details below.
    </p>
    <p class="pt-4 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        {{ __("Email: bakestreet.official@gmail.com") }}
    </p>
    <p class="pt-4 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        {{ __("Phone call: 03-12345678") }}
    </p>
    <p class="pt-4 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        {{ __("WhatsApp: 012-3456789") }}
    </p>
    <p class="pt-4 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        {{ __("Facebook: Bake Street") }}
    </p>
    <p class="pt-4 font-semibold text-lg sm:text-xl md:text-2xl text-gray-800 leading-tight">
        {{ __("Interested in inquiring about our product for corporate orders or bulk orders? Please fill in your details and our representative will be in touch with you.") }}
    </p>
</div>

<div class="appform-body mx-4 sm:mx-8 lg:mx-24">
    <div id="appform-form">
        <form method="POST" enctype="multipart/form-data" action="{{ route('corporateOrder.store') }}" id="appform-form-id" class="appform-form-class">
            @csrf
            <div class="appform-form-group">
                <label for="name" class="text-lg sm:text-xl appform-label">Name</label>
                <div class="appform-input-group">
                    <input type="text" id="name" name="name" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
                </div>
            </div>

            <div class="appform-form-group">
                <label for="phone" class="text-lg sm:text-xl appform-label">Mobile Number</label>
                <div class="appform-input-group">
                    <input type="text" id="phone" name="phone" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
                </div>
            </div>

            <div class="appform-form-group">
                <label for="email" class="text-lg sm:text-xl appform-label">E-mail Address</label>
                <div class="appform-input-group">
                    <input type="email" id="email" name="email" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
                </div>
            </div>

            <div class="appform-form-group">
                <label for="message" class="text-lg sm:text-xl appform-label">Your message</label>
                <div class="appform-input-group">
                    <textarea id="message" name="message" class="appform-form-control w-full p-2 border border-gray-300 rounded" rows="6" maxlength="3000" required></textarea>
                </div>
            </div>

            <div class="appform-form-group">
                <label for="location" class="text-lg sm:text-xl appform-label">Location</label>
                <select class="form-control w-full p-2 border border-gray-300 rounded @error('location') is-invalid @enderror" id="location" name="location" required>
                    <option value="">Select a state</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}" {{ old('location') == $state ? 'selected' : '' }}>{{ $state }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="photo" class="block mb-2 text-lg sm:text-xl font-bold text-gray-900 pt-4">Upload Cake Photo</label>
                <input class="form-control" name="photo" type="file" id="photo">
                <p class="text-sm text-gray-600">Please upload a photo to let us know what you're expecting. The photo must be a JPEG, PNG, or JPG file. Maximum size 2MB.</p>
            </div>

            <br>
            <br>
            <div class="appform-form-group">
                <button type="submit" id="appform-button" class="appform-btn appform-btn-primary appform-btn-lg appform-btn-block bg-orange-500 text-white p-2 rounded hover:bg-orange-600">Submit</button>
            </div>
        </form>
        <br>
        <br>
    </div>
</div>

@endsection
</x-app-layout>
