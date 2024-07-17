@extends('layouts.app')

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
<div class="mc-main-full">
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item">
                <img class="w-100" src="/img/newarrival.svg" alt="">
                <div class="container carousel-item-content img-overlay">
                    <div class="carousel-caption text-start">
                        <h1>New Arrival</h1>
                        <p>Indulge in the exquisite flavors of our Banquette Burnt Cheesecake.<br>Made with premium ingredients and baked to perfection.</p>
                        <a class="btn btn-outline-light px-4" href="/allproducts/33">More Info</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item active">
                <img class="w-100" src="/img/christmas.svg" alt="">
                <div class="container carousel-item-content img-overlay">
                    <div class="carousel-caption">
                        <h1>Celebrate this Christmas with us!</h1>
                        <p>Whether you're celebrating with family or friends, our Christmas Special Raspberry Cake is sure to be the highlight of your holiday feast. Order now and add a touch of sweetness to your Christmas celebrations!</p>
                        <a class="btn btn-outline-light px-4" href="/christmas">More Info</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="/img/bestselling.svg" alt="">
                <div class="container carousel-item-content img-overlay">
                    <div class="carousel-caption text-end">
                        <h1>Best Selling Cake</h1>
                        <p>An almond and pistachio shell filled with a dreamy<br>pistachio cream layer, topped with a thick vegan chocolate<br>ganache and finished with a sprinkle of pistachio nuts.</p>
                        <a class="btn btn-outline-light px-4" href="/allproducts/61">More Info</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<br>

<div class="py-10 bg-transparent pb-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-amber-500 hover:text-orange-500 font-bold">WHAT WE SERVE</p>
            <h2 class="text-4xl font-bold mb-6">Your Favourite Cake Ordering Platform</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('showallproduct') }}" class="text-decoration-none text-dark text-center">
                <img src="/img/orderonlineicon.png" alt="Effortless Online Ordering">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Effortless Online Ordering</h4>
                <p class="text-gray-600">Place your orders quickly and easily with our user-friendly online platform. Enjoy a hassle-free experience from browsing to checkout.</p>
            </a>

            <a href="{{ route('showallproduct') }}" class="text-decoration-none text-dark text-center">
                <img src="/img/deliveryicon.png" alt="Fast and Reliable Doorstep Delivery">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Reliable Doorstep Delivery</h4>
                <p class="text-gray-600">Get your favorite baked goods delivered straight to your doorstep with our swift and dependable delivery option. Freshness guaranteed.</p>
            </a>

            <a href="/selfcollect" class="text-decoration-none text-dark text-center">
                <img src="/img/pickupicon.png" alt="Convenient In-Store Pickup">
                <h4 class="font-bold text-3xl text-gray-800 leading-tight">Convenient In-Store Pickup</h4>
                <p class="text-gray-600">Choose our convenient pickup option and collect your order at your preferred time. Skip the wait and enjoy your treats sooner.</p>
            </a>
        </div>
        <br>
    </div>
</div>

<!-- Blog Preview Section -->
<div class="py-10 bg-transparent pb-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-6">Latest Blog Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestBlogPosts as $post)
            <div class="bg-gray-100 border rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                <div class="p-6 pb-3">
                    <h3 class="text-xl font-semibold mb-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-amber-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                    <div class="flex justify-between">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-amber-500 hover:text-orange-500 font-bold">Read More</a>
                    <div class="card-footer text-muted text-md">
                        {{ $post->created_at->format('F j, Y') }} • {{ $post->read_time }} min read
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <br>
        <div class="text-center">
            <a href="/blog" class="readmore text-orange-600 px-3 py-2.5 border leading-4 rounded-md hover:text-orange-500 focus:text-black focus:outline-none active:bg-amber-100 active:text-orange-500">Show All</a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-8">
<div class="accordion bg-transparent" id="accordionExample">
    <h2 class="text-3xl font-bold mb-6">Frequently Asked Questions</h2>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-amber-400" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Are all products on Bake Street Halal?
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>All of our bakers use Halal certified ingredients to bake. </strong> We do have a couple of alcoholic cakes in our marketplace, which we have mentioned that they contain alcohol in the product details.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                I received my cake and it looks different from the pictures on the website.
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Sometimes the cake you have received may differ from what was shown on our website.</strong> The photos on display are for illustration purposes, so do take the lighting and photo editing used into consideration. And also, the cakes would not look exactly the same as they are all handmade by our bakers.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Accordion Item #3
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>
</div>
<div class="readmorebutt">
    <a href="/faq" class="readmore text-orange-600 px-3 py-2.5 border leading-4 rounded-md hover:text-orange-500 focus:text-black focus:outline-none active:bg-amber-100 active:text-orange-500">Read More</a>
</div>
</div>
<br>
<br>


<div x-data="{ open: true }" x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
    <div @click.away="open = false" class="bg-white rounded-lg p-8 shadow-lg max-w-md mx-auto">
    <div class="flex justify-center">
        <img src="/img/logo.svg"  class="block h-28 w-auto" alt="logo">
    </div>
    <br>
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Subscribe to Our Newsletter!</h2>
        <p class="text-lg text-gray-800 mb-4">Stay in the loop with our latest cake creations, special offers, and exclusive events!</p>

        <form action="{{ route('subscribe') }}" method="POST" class="mb-4">
            @csrf
            <label for="email" class="block text-gray-700 mb-2">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email address" required class="w-full px-3 py-2 border rounded-lg">
            <div class="flex justify-center mt-3">
                <button type="submit" class="bg-amber-500 text-white font-bold px-4 py-2 rounded-lg hover:bg-orange-500">Subscribe</button>
            </div>
        </form>
        <div class="flex justify-center">
        <button @click="open = false" class="bg-gray-500 text-white font-bold px-4 py-2 rounded-lg hover:bg-gray-700">Close</button>
        </div>
    </div>
</div>

@endsection
