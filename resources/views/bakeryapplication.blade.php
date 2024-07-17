<x-app-layout>
@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/application/create" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Application</a>
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

<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Are you a baker?') }}
</h1>
<div class="mx-24 applicationform">
    <p class="pt-5 font-semibold text-2xl text-gray-800 leading-tight">
        Do you bake? Want to be a part of the Bake Street family? Get with us!
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Whether you've just learnt the amazing art of baking or you've been baking for a while now and want to get your cakes out there to Malaysians everywhere, you're at the right place!") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("We love working with talented individuals and if you make yummy cakes, we're already excited and we want to meet you.") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Leave us your contact details and we'll be sure to get back to you.") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("You should let us know your") }}
    </p>
    <ul class="list-disc pt-3 font-semibold text-xl text-gray-800 leading-tight">
        <li>Name</li>
        <li>E-mail Address</li>
        <li>Phone Number</li>
        <li>Name of Bakery</li>
        <li>Location of Bakery</li>
        <li>Website/Facebook/Instagram Link</li>
    </ul>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Do include this information so that we can get back to you quicker. Looking forward!") }}
    </p>
</div>

<div class="appform-body">
    <div id="appform-form">
    <form method="POST" action="/application" id="appform-form-id" class="appform-form-class">
        @csrf
        <div class="appform-form-group">
            <label for="Name" class="text-xl appform-label">Name</label>
            <div class="appform-input-group">
                <input type="text" id="name" name="name" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Email" class="text-xl appform-label">E-mail Address</label>
            <div class="appform-input-group">
                <input type="email" id="email" name="email" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Phone Number" class="text-xl appform-label">Mobile Number</label>
            <div class="appform-input-group">
                <input type="text" id="phone" name="phone" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Name of Bakery" class="text-xl appform-label">Name of Bakery</label>
            <div class="appform-input-group">
                <input type="text" id="bakery_name" name="bakery_name" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="social_media_link" class="text-xl appform-label">Website/ Facebook/ Instagram Link</label>
            <div class="appform-input-group">
                <input type="url" id="social_media_link" name="social_media_link" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
        <label for="bakery_location" class="text-xl appform-label">Location of Bakery</label>
        <div class="appform-input-group">
            <select id="bakery_location" name="bakery_location" class="appform-form-control w-full border border-gray-300 rounded" required>
                <option value="" selected disabled>Select State</option>
                <option value="Johor">Johor</option>
                <option value="Kedah">Kedah</option>
                <option value="Kelantan">Kelantan</option>
                <option value="Melaka">Melaka</option>
                <option value="Negeri Sembilan">Negeri Sembilan</option>
                <option value="Pahang">Pahang</option>
                <option value="Perak">Perak</option>
                <option value="Perlis">Perlis</option>
                <option value="Pulau Pinang">Pulau Pinang</option>
                <option value="Sabah">Sabah</option>
                <option value="Sarawak">Sarawak</option>
                <option value="Selangor">Selangor</option>
                <option value="Terengganu">Terengganu</option>
                <option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
                <option value="Wilayah Persekutuan Labuan">Wilayah Persekutuan Labuan</option>
                <option value="Wilayah Persekutuan Putrajaya">Wilayah Persekutuan Putrajaya</option>
                </select>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Address" class="text-xl appform-label">Address</label>
            <div class="appform-input-group">
                <textarea id="address" name="address" class="appform-form-control w-full p-2 border border-gray-300 rounded" rows="3" maxlength="500" required></textarea>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Message" class="text-xl appform-label">Your message</label>
            <div class="appform-input-group">
                <textarea id="message" name="message" class="appform-form-control w-full p-2 border border-gray-300 rounded" rows="6" maxlength="3000" required></textarea>
            </div>
        </div>

        <div class="appform-form-group">
            <button type="submit" id="appform-button" class="appform-btn appform-btn-primary appform-btn-lg appform-btn-block">Submit</button>
        </div>
    </form>
    </div>
</div>
<br>
<br>
@endsection
</x-app-layout>
