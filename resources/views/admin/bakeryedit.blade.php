@extends('layouts.admin')

@section('content')
<div class="py-3 pb-0 bg-amber-400">
    <div class="max-w-7xl mx-16 sm:px-6 lg:px-8">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900">Home &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="/admin/bakerylist" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery List &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    @if(session('previous_page') == 'searchbakery')
                    <a href="" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Bakery Search Results &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                    @endif
                </li>
                <li class="flex items-center">
                    <a href="{{ route('admin.showBakery', ['id' => $user->id]) }}" class="text-gray-700 hover:text-gray-900"> &nbsp&nbsp Bakery Details &nbsp&nbsp</a>
                    <i class="fa-solid fa-angle-right" style="color: #7a7a7a;"></i>
                </li>
                <li class="flex items-center">
                    <a href="" class="text-gray-700 hover:text-gray-900">&nbsp&nbsp Edit Bakery</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container mx-auto p-4 mb-8">
    <h1 class="text-4xl font-bold mb-4 pt-8">Edit Bakery</h1>

    <form action="{{ route('admin.bakery.update', $user->id) }}" method="POST" onsubmit="return validateForm()">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-lg font-medium">Name</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-lg font-medium">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-lg font-medium">Phone</label>
            <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-lg font-medium">Address</label>
            <input type="text" id="address" name="address" value="{{ $user->address }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="location" class="block text-lg font-medium">Bakery Location</label>
            <input type="text" name="location" id="location" value="{{ $user->bakery->location ?? '' }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="usertype" class="block text-lg font-medium">User Type</label>
            <select id="usertype" name="usertype" class="w-full p-2 border border-gray-300 rounded" required>
                <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User</option>
                <option value="bakery" {{ $user->usertype == 'bakery' ? 'selected' : '' }}>Bakery</option>
            </select>
        </div>

        <div class="mb-4 text-center">
            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md"><i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> &nbspUpdate Bakery</button>
        </div>
    </form>

    <form action="{{ route('admin.bakery.destroy', $user->id) }}" method="POST" class="mb-4 text-center" onsubmit="return confirm('Are you sure you want to delete this bakery?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-7 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md"><i class="fa-solid fa-trash"></i> &nbspDelete Bakery</button>
    </form>
</div>

<script>
    function validateForm() {
        const requiredFields = document.querySelectorAll('input[required], select[required]');
        for (const field of requiredFields) {
            if (!field.value.trim()) {
                alert('Please fill out all required fields.');
                field.focus();
                return false;
            }
        }
        return true;
    }
</script>
@endsection
