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
                    <a href="/contactus/create" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Customer Service</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<h1 class="text-center pt-10 font-semibold text-4xl text-gray-800 leading-tight">
    {{ __('Need Help? Contact Us Now!') }}
</h1>
<div class="mx-24 applicationform">
    <p class="pt-5 font-semibold text-2xl text-gray-800 leading-tight">
        If you are still unsure about the answers we have provided on FAQs, feel free to contact us! We are pleased to assist you :]
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Company Name: Bake Street Sdn Bhd [1234567-H]") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Email: bakestreet.official@gmail.com") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Phone call: 03-12345678") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("WhatsApp: 012-3456789") }}
    </p>
    <p class="pt-4 font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Facebook: Bake Street") }}
    </p>
</div>

<div class="appform-body">
    <div id="appform-form">
    <form method="POST" action="/contactus" id="appform-form-id" class="appform-form-class">
        @csrf
        <div class="appform-form-group">
            <label for="Name" class="text-xl appform-label">Name</label>
            <div class="appform-input-group">
                <input type="text" id="name" name="name" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Phone Number" class="text-xl appform-label">Mobile Number</label>
            <div class="appform-input-group">
                <input type="text" id="phone" name="phone" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
            </div>
        </div>

        <div class="appform-form-group">
            <label for="Email" class="text-xl appform-label">E-mail Address</label>
            <div class="appform-input-group">
                <input type="email" id="email" name="email" class="appform-form-control w-full p-2 border border-gray-300 rounded" required>
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
