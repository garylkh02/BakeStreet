<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-none dark:border-none">
<script src="https://kit.fontawesome.com/5e7cbc164a.js" crossorigin="anonymous"></script>
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/">
                        <div class="logo">
                        <img src="/img/logo.svg"  class="block h-9 w-auto" alt="logo">
                        </div>
                        </a>
                    </div>
            </div>
            

            <div class="hidden md:flex sm:items-center sm:ms-6">
            <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search anything!" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </button>
                </form>

                @if (Route::has('login'))
                <nav>
                        @auth
                        <div class="hidden md:flex sm:items-center sm:ms-0">
                            <div class="ms-4 relative mr-4">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 text-lg leading-4 font-medium rounded-md text-gray-600 dark:text-gray-600 dark:bg-transparent hover:text-black dark:hover:text-black focus:outline-none focus:bg-amber-100 dark:focus:bg-amber-100 dark:active:bg-amber-100 active:bg-amber-100 transition ease-in-out duration-150">
                                                    {{ Auth::user()->name }}

                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Account') }}
                                        </div>

                                        @if (Auth::user()->usertype == 'bakery')
                                            <x-dropdown-link href="{{ route('bakery.dashboard') }}" :active="request()->routeIs('bakery.dashboard')">
                                                {{ __('Dashboard') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{ route('bakery.orderlist') }}" :active="request()->routeIs('bakery.dashboard')">
                                                {{ __('Orders') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{ route('bakery.listproduct') }}">
                                                {{ __('Menu') }}
                                            </x-dropdown-link>
                                        @endif

                                        @if (Auth::user()->usertype == 'admin')
                                            <x-dropdown-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('bakery.dashboard')">
                                                {{ __('Dashboard') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{ route('admin.enquirylist') }}" :active="request()->routeIs('bakery.dashboard')">
                                                {{ __('Enquiries') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{ route('admin.bakeryApplicationList') }}" :active="request()->routeIs('bakery.dashboard')">
                                                {{ __('Applications') }}
                                            </x-dropdown-link>
                                        @endif

                                        @if (Auth::user()->usertype == 'user')
                                        <x-dropdown-link href="{{ route('dashboard') }}">
                                            {{ __('Dashboard') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('orders.list') }}">
                                            {{ __('Orders') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('loyalty.page') }}">
                                            {{ __('Earn Points') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('coupons') }}">
                                            {{ __('Coupons') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('fav.list') }}">
                                            {{ __('Favourites') }}
                                        </x-dropdown-link>
                                        @endif

                                        <x-dropdown-link href="{{ route('profile.show') }}">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>
                                        

                                       <!--  @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                                {{ __('API Tokens') }}
                                            </x-dropdown-link>
                                        @endif -->

                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                        <!-- Shopping Cart Icon -->
                        @if (Auth::user()->usertype == 'user')
                        <a href="{{ route('cart.show') }}"  class="shake-on-click focus:outline-none">
                            <i class="fa-solid fa-bag-shopping fa-xl dark:bg-gray-800 text-gray-700 dark:text-gray-600 hover:text-black dark:hover:text-black active:text-black"></i>
                            @if ($cartCount > 0)
                                <span class='badge badge-warning' id='lblCartCount'>{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif
                    
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="ms-6 relative mr-1 inline-flex items-center px-3 py-2 text-lg leading-4 font-medium rounded-md text-gray-600 dark:text-gray-600 dark:bg-transparent hover:text-black dark:hover:text-black hover:bg-amber-100 dark:hover:bg-amber-100 focus:outline-none focus:bg-amber-100 dark:focus:bg-amber-100 dark:active:bg-amber-100 active:bg-amber-100 transition ease-in-out duration-150"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center px-3 py-2 text-lg leading-4 font-medium rounded-md text-gray-600 dark:text-gray-600 dark:bg-transparent hover:text-black dark:hover:text-black hover:bg-amber-100 dark:hover:bg-amber-100 focus:outline-none focus:bg-amber-100 dark:focus:bg-amber-100 dark:active:bg-amber-100 active:bg-amber-100 transition ease-in-out duration-150"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
                @endif
               
            </div>
            

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                    
                        <!-- Search Bar -->
                        <form action="{{ route('search') }}" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Search anything!" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
                            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                            </button>
                        </form>


                <button @click="open = ! open" class="ms-3 mr-1 inline-flex items-center justify-center p-2 rounded-md text-amber-500 dark:text-amber-500 hover:text-amber-600 dark:hover:text-amber-600 hover:bg-amber-100 dark:hover:bg-amber-100 focus:outline-none focus:bg-amber-100 dark:focus:bg-amber-100 focus:text-amber-600 dark:focus:text-amber-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        </div>
        <!-- Secondary Navigation Bar Content -->
                <div class="w-full bg-amber-400 mx-auto px-4 sm:px-6 lg:px-10 hidden md:block z-50">
                    <div class="flex justify-between h-16">
                        <!-- Your secondary navigation links here -->
                        <x-nav-link class="text-lg" href="/christmas" :active="request()->routeIs('bakery.orders')">
                            {{ __('Christmas 2024') }}
                        </x-nav-link> 

                        <x-nav-link href="/allproducts" :active="request()->routeIs('bakery.orders')">
                            {{ __('All Products') }}
                        </x-nav-link> 

                        <!-- Dropdown List -->

                        <div class="relative" x-data="{ open: false }">
                            <x-nav-link>
                                <span class="inline-flex rounded-md">
                                    <button type="button" @click="open = !open" class="inline-flex items-center px-3 py-[9px] border-none text-lg leading-4 font-medium rounded-md text-gray-700 dark:text-gray-600 bg-amber-400 dark:bg-amber-400 hover:text-black dark:hover:text-black focus:outline-none transition ease-in-out duration-150">
                                    {{ __('Shop By') }}
                                        <svg class="ms-2 -me-0.5 h-10 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-nav-link>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg  z-50">
                                <a href="{{ route('bakeries.list') }}"  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Bakery') }}</a>
                                <a href="{{ route('corporateOrder') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Corporate Order') }}</a>
                                <!-- Add more dropdown items as needed -->
                            </div>
                        </div>
                        
                        <div class="relative" x-data="{ open: false }">
                            <x-nav-link>
                                <span class="inline-flex rounded-md">
                                <button type="button" @click="open = !open" class="inline-flex items-center px-3 py-[9px] border-none text-lg leading-4 font-medium rounded-md text-gray-700 dark:text-gray-600 bg-amber-400 dark:bg-amber-400 hover:text-black dark:hover:text-black focus:outline-none transition ease-in-out duration-150">
                                    {{ __('Occasions') }}
                                        <svg class="ms-2 -me-0.5 h-10 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-nav-link>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg z-50">
                                <a href="/christmas" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Christmas') }}</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Product 2') }}</a>
                                <!-- Add more dropdown items as needed -->
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <x-nav-link>
                                <span class="inline-flex rounded-md">
                                <button type="button" @click="open = !open" class="inline-flex items-center px-3 py-[9px] border-none text-lg leading-4 font-medium rounded-md text-gray-700 dark:text-gray-600 bg-amber-400 dark:bg-amber-400 hover:text-black dark:hover:text-black focus:outline-none transition ease-in-out duration-150">
                                    {{ __('Location') }}
                                        <svg class="ms-2 -me-0.5 h-10 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-nav-link>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg z-50">
                                <a href="/klselangor" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('KL / Selangor') }}</a>
                                <a href="/penang" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Penang') }}</a>
                                <a href="/jb" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Johor Bahru') }}</a>
                                <!-- Add more dropdown items as needed -->
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <x-nav-link>
                                <span class="inline-flex rounded-md">
                                <button type="button" @click="open = !open" class="inline-flex items-center px-3 py-[9px] border-none text-lg leading-4 font-medium rounded-md text-gray-700 dark:text-gray-600 bg-amber-400 dark:bg-amber-400 hover:text-black dark:hover:text-black focus:outline-none transition ease-in-out duration-150">
                                    {{ __('Delivery Time') }}
                                        <svg class="ms-2 -me-0.5 h-10 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-nav-link>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg z-50">
                                <a href="/5hours" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('5 Hours') }}</a>
                                <a href="/1day" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('1 Day') }}</a>
                                <a href="/2days" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('2 Days') }}</a>
                                <a href="/3days" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('3 Days') }}</a>
                                <a href="/selfcollect" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Self-Collect') }}</a>
                                <!-- Add more dropdown items as needed -->
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <x-nav-link>
                                <span class="inline-flex rounded-md">
                                <button type="button" @click="open = !open" class="inline-flex items-center px-3 py-[9px] border-none text-lg leading-4 font-medium rounded-md text-gray-700 dark:text-gray-600 bg-amber-400 dark:bg-amber-400 hover:text-black dark:hover:text-black focus:outline-none transition ease-in-out duration-150">
                                    {{ __('Contact Us') }}
                                        <svg class="ms-2 -me-0.5 h-10 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-nav-link>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg z-50">
                                <a href="/faq" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('FAQ') }}</a>
                                <a href="/customise-cake" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Cake Customisation') }}</a>
                                <a href="/contactus/create" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Customer Service') }}</a>    
                                <a href="/application/create" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Are you a baker?') }}</a>
                                <a href="/subscribe" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Newsletter Subscription') }}</a>
                                <!-- Add more dropdown items as needed -->
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="space-y-1 bg-amber-100">
            <x-responsive-nav-link href="{{ route('christmas') }}" :active="request()->routeIs('christmas')">
                {{ __('Christmas 2024') }}
                <div class="font-medium text-sm text-gray-500">Celebrate this Christmas with us!</div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="dark:bg-amber-100 bg-amber-100">
            <div class="mt-0">
                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Shop By') }}
                    </div>
                    <x-responsive-nav-link href="/allproducts">
                        {{ __("All Products") }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('bakeries.list') }}">
                        {{ __("Bakery") }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('corporateOrder') }}">
                        {{ __("Corporate Order") }}
                    </x-responsive-nav-link>

                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Occasions') }}
                    </div>
                    <x-responsive-nav-link href="/christmas">
                        {{ __('Christmas') }}
                    </x-responsive-nav-link>
               
                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Location') }}
                    </div>
                    <x-responsive-nav-link href="/klselangor">
                        {{ __('KL / Selangor') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/penang">
                        {{ __('Penang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/jb">
                        {{ __('Johor Bahru') }}
                    </x-responsive-nav-link>

                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Delivery Time') }}
                    </div>
                    <x-responsive-nav-link href="/5hours">
                        {{ __('5 Hours') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/1day">
                        {{ __('1 Day') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/2days">
                        {{ __('2 Days') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/3days">
                        {{ __('3 Days') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/selfcollect">
                        {{ __('Self-Collect') }}
                    </x-responsive-nav-link>

                <div class="border-t border-gray-400 dark:border-gray-400"></div>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Contact Us') }}
                    </div>
                    <x-responsive-nav-link href="/faq">
                        {{ __('FAQ') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/customise-cake">
                        {{ __('Cake Customisation') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/contactus/create">
                        {{ __('Customer Service') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/application/create">
                        {{ __('Are You a Baker?') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/subscribe">
                        {{ __('Newsletter Subscription') }}
                    </x-responsive-nav-link>

                <!-- Account Management -->
                <div class="border-t border-gray-400 dark:border-gray-400"></div>

                    <div class="block px-4 py-2 text-xs text-gray-500">
                        {{ __('Account Management') }}
                    </div>

                @if (Auth::check())
                @if (Auth::user()->usertype == 'bakery')
                    <x-responsive-nav-link href="{{ route('bakery.dashboard') }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('bakery.orderlist') }}">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('bakery.listproduct') }}">
                        {{ __('Menu') }}
                    </x-responsive-nav-link>
                @endif

                @if (Auth::user()->usertype == 'admin')
                    <x-responsive-nav-link href="{{ route('admin.dashboard') }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.enquirylist') }}">
                        {{ __('Enquiries') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.bakeryApplicationList') }}">
                        {{ __('Applications') }}
                    </x-responsive-nav-link>
                @endif

                @if (Auth::user()->usertype == 'user')
                    <x-responsive-nav-link href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('orders.list') }}">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('loyalty.page') }}">
                        {{ __('Earn Points') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('coupons') }}">
                        {{ __('Coupons') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('fav.list') }}">
                        {{ __('Favourites') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="hover:bg-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @else
                <x-responsive-nav-link href="{{ route('login') }}">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
            @endif
            </div>
        </div>
        </div>
</nav>

