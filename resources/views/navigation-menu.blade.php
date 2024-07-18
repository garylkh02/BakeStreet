<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-none dark:border-none">
<script src="https://kit.fontawesome.com/5e7cbc164a.js" crossorigin="anonymous"></script>
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="flex justify-between h-20">
            <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ Auth::user()->usertype == 'bakery' ? route('bakery.dashboard') : (Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('welcome')) }}">
                        <div class="logo">
                        @if (Auth::user()->usertype == 'user')            
                            <img src="/img/logo.svg"  class="block h-9 w-auto" alt="logo">
                        @endif
                        @if (Auth::user()->usertype == 'admin')            
                            <img src="/img/adminlogo.svg"  class="block h-9 w-auto" alt="logo">
                        @endif
                        @if (Auth::user()->usertype == 'bakery')            
                            <img src="/img/bakerylogo.svg"  class="block h-9 w-auto" alt="logo">
                        @endif
                        </div>
                        </a>
                    </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 lg:flex">
        
                    <!-- bakery links -->
                    @if (Auth::user()->usertype == 'bakery')
                        <x-nav-link href="{{ route('bakery.orderlist') }}" class="active:text-orange-500">
                            {{ __('Orders') }}
                        </x-nav-link> 
            
                        <x-nav-link href="{{ route('bakery.listproduct') }}" class="active:text-orange-500">
                            {{ __('Menu') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('bakery.manageCategories') }}" class="active:text-orange-500">
                            {{ __('Category') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('bakery.reviews') }}" class="active:text-orange-500">
                            {{ __('Feedback') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('bakerycontactus.create') }}" :active="request()->routeIs('bakery.contact')" class="active:text-orange-500">
                            {{ __('Contact Us') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('bakery.custom.orders') }}" class="active:text-orange-500">
                            {{ __('Cake Customisation') }}
                        </x-nav-link> 
                    @endif

                     <!-- admin links -->
                     @if (Auth::user()->usertype == 'admin')
                        <x-nav-link href="{{ route('admin.userlist') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-user"></i>&nbsp;{{ __('User') }}
                        </x-nav-link> 
            
                        <x-nav-link href="{{ route('admin.bakerylist') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-shop"></i>&nbsp;{{ __('Bakery') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('admin.enquirylist') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-circle-info"></i>&nbsp;{{ __('Enquiry') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('admin.bakeryApplicationList') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-file-import"></i>&nbsp;{{ __('Application') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('corporateOrders.list') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-building"></i>&nbsp;{{ __('Corporate Order') }}
                        </x-nav-link> 

                        <x-nav-link href="{{ route('admin.newsletter.form') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-solid fa-envelopes-bulk"></i>&nbsp;{{ __('Newsletter') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.bloglist') }}" class="active:text-amber-500 hover:text-orange-500">
                        <i class="fa-brands fa-microblog"></i>&nbsp;{{ __('Blog') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>
            

            <div class="hidden lg:flex sm:items-center sm:ms-6">
                @if (Auth::user()->usertype == 'user')             
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search anything!" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </button>
                </form>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-4 relative mr-4">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-lg leading-4 font-medium rounded-md text-gray-600 hover:text-black focus:outline-none focus:bg-amber-100 active:bg-amber-100 transition ease-in-out duration-150">
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
                            
                            @if (Auth::user()->usertype == 'admin')
                                <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.enquirylist') }}">
                                    {{ __('Enquiries') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.bakeryApplicationList') }}">
                                    {{ __('Applications') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('corporateOrders.list') }}">
                                    {{ __('Corporate Order') }}
                                </x-dropdown-link>
                            @endif

                            @if (Auth::user()->usertype == 'bakery')
                            <x-dropdown-link href="{{ route('bakery.dashboard') }}" :active="request()->routeIs('bakery.dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('bakery.orderlist') }}">
                                {{ __('Orders') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('bakery.listproduct') }}">
                                {{ __('Menu') }}
                            </x-dropdown-link>
                            @elseif (Auth::user()->usertype == 'user')
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

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

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
                @if (Auth::user()->usertype == 'user')             
                    <!-- Shopping Cart Icon -->
                    <a href="{{ route('cart.show') }}"  class="shake-on-click focus:outline-none">
                        <i class="fa-solid fa-bag-shopping fa-xl dark:bg-gray-800 text-gray-700 dark:text-gray-600 hover:text-black dark:hover:text-black active:text-black"></i>
                        @if ($cartCount > 0)
                            <span class='badge badge-warning' id='lblCartCount'>{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
            </div>
            

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                    
                        <!-- Search Bar -->
                        @if (Auth::user()->usertype == 'user')     
                        <form action="{{ route('search') }}" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Search anything!" class="py-1 px-3 sm:px-5 lg:px-5 xl:px-5 w-full rounded-l-md border-neutral-200 focus:outline-none focus:ring focus:border-amber-400">
                            <button type="submit" class="bg-amber-400 hover:bg-amber-500 text-white py-1 px-4 rounded-r-md flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                            </button>
                        </form>
                        @endif

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
        @if (Auth::check())
            @if (Auth::user()->usertype == 'user')
                <div class="w-full bg-amber-400 mx-auto px-4 sm:px-6 lg:px-10 hidden md:block">
                    <div class="flex justify-between h-16">
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

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg">
                                <a href="{{ route('bakeries.list') }}"  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Bakery') }}</a>
                                <a href="{{ route('corporateOrder') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Corporate Order') }}</a>
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
                                <a href="/christmas" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Christmas 2024') }}</a>
                                <a href="/anniversary" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Anniversary') }}</a>
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

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border-4 border-white divide-y divide-gray-700 dark:divide-gray-700 rounded-md shadow-lg">
                                <a href="/faq" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('FAQ') }}</a>
                                <a href="/customise-cake" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Cake Customisation') }}</a>
                                <a href="/contactus/create" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Customer Service') }}</a>    
                                <a href="/application/create" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Are you a baker?') }}</a>
                                <a href="/subscribe" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-700 hover:bg-amber-300 dark:hover:bg-amber-300 hover:text-black">{{ __('Newsletter Subscription') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
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
                    <x-responsive-nav-link href="/anniversary">
                        {{ __('Anniversary') }}
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
                    <x-responsive-nav-link href="{{ route('corporateOrders.list') }}">
                        {{ __('Corporate Order') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.newsletter.form') }}">
                        {{ __('Newsletter') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.bloglist') }}">
                        {{ __('Blog') }}
                    </x-responsive-nav-link>



                @endif
                
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
                <x-responsive-nav-link href="{{ route('bakery.manageCategories') }}">
                    {{ __('Category') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('bakery.custom.orders') }}">
                    {{ __('Cake Customisation') }}
                </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Route::has('login'))
                    @auth
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
                    @endauth
                @endif
            </div>
        </div>
        </div>
</nav>

