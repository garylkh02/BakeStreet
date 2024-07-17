<x-app-layout>

    <div class="flex-center position-ref full-height">
           
            <div class="content">
               
                <div class="title m-b-md">
                    Welcome
                </div>
                <p class="mssg">{{ session('mssg') }}</p>

                <div class="links">
                    <a href="/allproducts">All Products</a>
                    <a href="/allproducts/create">Add New Menu</a>
                    <a href="/about">About</a>
                    
                </div>
            </div>
        </div>
</x-app-layout>