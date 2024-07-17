<x-app-layout>

@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900">Dashboard &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    <a href="/favourite" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Favourite Cakes</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="text-center pt-2 pb-0">
    <h1 class="text-4xl font-semibold text-gray-800 leading-tight">
        {{ __('Favourite Cakes') }}
    </h1>
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

<div class="container mx-auto py-8">
    @if($wishlistItems->isEmpty())
    <div class="text-center py-4">
        <p class="text-2xl text-gray-600 mt-5">Opps! You haven't add anything as your favourite.. &nbsp;<i class="fa-regular fa-heart"></i></p>
    </div>
    @else
        @foreach($wishlistItems as $cake)
        <a href="/allproducts/{{ $cake->id }}">
            <div class="flex justify-center">
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg w-5/6 h-auto flex items-center">
                <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:block">
                    <img src="{{ $cake->photo }}" alt="Cake Image" class="w-40 h-40 object-cover rounded-md">
                </div>
                    <div class="ml-4 flex flex-col justify-between h-4/5 w-10/12">
                        <h3 class="text-2xl font-semibold text-gray-900">{{ $cake->name }}</h3>
                        <h3 class="text-xl font-light text-gray-600">{{ $cake->description }}</h3>
                        <p class="text-orange-500 font-bold text-xl">RM {{ number_format($cake->price, 2) }}</p>
                    </div>
                </div>
            </div>
        </a>
        <br>
        @endforeach
    @endif
</div>
    

@endsection
</x-app-layout>
