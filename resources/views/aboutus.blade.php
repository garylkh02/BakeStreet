<x-app-layout>

@section('content')
<div class="banner">
    <img src="/img/aboutcover.png" class="banner-image" alt="Banner Image">
</div>

<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/about-us" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp About Us</a>
                </li>
            </ol>
        </nav>
    </div>
</div>


<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4">
        <br>
            <h1 class="font-semibold text-5xl text-gray-800 leading-tight pb-2">
                {{ __('About Bake Street') }}
            </h1>
            <p class="text-lg">Welcome to Bake Street, your one-stop platform for delicious cakes from a variety of bakeries. Our mission is to bring you the best cakes from local bakers, all in one convenient location. Whether you're looking for a birthday cake, wedding cake, or just something sweet to brighten your day, Bake Street has you covered.</p>
            <br>
            <h1 class="font-semibold text-4xl text-gray-800 leading-tight pb-2">
            {{ __('Our Story') }}
            </h1>
            <p class="text-lg">Bake Street was founded with the vision of supporting local bakeries and providing customers with a wide selection of high-quality cakes. We believe in the power of community and the joy that comes from sharing a beautifully crafted cake.</p>
            <br>
            <h1 class="font-semibold text-4xl text-gray-800 leading-tight pb-2">
            {{ __('What We Offer') }}
            </h1>
            <ul class="text-lg">
                <li><strong>Diverse Selection:</strong> Choose from a wide range of cakes, including classic flavours, modern creations, and dietary-specific options.</li>
                <li><strong>Convenient Ordering:</strong> Easily order your favourite cakes for delivery or pick-up.</li>
                <li><strong>Support Local Bakers:</strong> Every purchase helps support local businesses and bakers.</li>
            </ul>
            <br>
            <h1 class="font-semibold text-4xl text-gray-800 leading-tight pb-2">
            {{ __('Our Commitment') }}
            </h1>
            <p class="text-lg">We are committed to providing exceptional service and high-quality products. Our team works tirelessly to ensure that every cake ordered through Bake Street meets our high standards for taste and presentation.</p>
            <br>
            <h1 class="font-semibold text-4xl text-gray-800 leading-tight pb-2">
            {{ __('Contact Us') }}
            </h1>
            <p>If you have any questions or feedback, please don't hesitate to reach out to us at <a href="mailto:bakestreet.official@gmail.com">bakestreet.official@gmail.com</a>. We look forward to serving you!</p>
            <br>
            <br>
            <div class="flex justify-center">
                <img src="/img/logo.svg"  class="block h-28 w-auto" alt="logo">
            </div>
            <br>
        </div>
</div>
<br>
<br>
@endsection

</x-app-layout>
