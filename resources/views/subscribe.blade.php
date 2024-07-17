<x-app-layout>
@section('content')
<div class="py-4 pb-2">
    <div class="mx-auto">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none px-4 sm:px-8 inline-flex">
                <li class="flex items-center">
                    <a href="/" class="text-gray-700 hover:text-gray-900">Home &nbsp;&nbsp;</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/subscribe" class="text-gray-700 hover:text-gray-900">&nbsp;&nbsp;Newsletter Subscription</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="p-4 bg-green-500 text-white mx-4 sm:mx-0">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 bg-red-500 text-white mx-4 sm:mx-0">
        {{ session('error') }}
    </div>
@endif

<h1 class="text-center pt-10 font-semibold text-3xl sm:text-4xl text-gray-800 leading-tight">
    {{ __('Subscribe to Newsletter!') }}
</h1>
<br>
<br>
<div class="flex justify-center">
    <div class="w-full max-w-lg px-4 sm:px-0">
        <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="block mb-2 text-sm font-bold text-xl text-gray-900">Subscribe to our newsletter:</label>
                <input type="email" name="email" id="email" placeholder="Email Address" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            </div>

            <div class="pt-3">
                <button type="submit" class="bg-orange-500 hover:bg-amber-500 active:bg-orange-500 text-white text-xl font-bold py-2.5 px-20 rounded w-full">
                    Subscribe
                </button>
            </div>
        </form>
        <br>
        <form action="{{ route('unsubscribe') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="block mb-2 text-sm font-bold text-xl text-gray-900">Unsubscribe from our newsletter:</label>
                <input type="email" name="email" id="unsubscribe-email" placeholder="Email Address" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required>
            </div>
            <div class="pt-3">
                <button type="submit" class="bg-gray-500 hover:bg-gray-800 active:bg-orange-500 text-white text-xl font-bold py-2.5 px-20 rounded w-full">
                    Unsubscribe
                </button>
            </div>
        </form>
    </div>
</div>
<br>
<br>
@endsection
</x-app-layout>
