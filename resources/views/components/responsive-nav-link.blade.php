@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent hover:bg-amber-400 dark:hover:bg-amber-400 hover:text-white dark:hover:text-white hover:border-orange-600 dark:hover:border-orange-600 text-start text-base font-medium text-gray-700 dark:text-gray-700 bg-amber-100 dark:bg-amber-100 focus:outline-none focus:text-gray-700 dark:focus:text-gray-700 focus:bg-amber-400 dark:focus:bg-amber-400 focus:border-none dark:focus:border-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-700 dark:text-gray-700 hover:text-white dark:bg-amber-100 dark:hover:text-white hover:bg-amber-400 dark:hover:bg-amber-400 hover:border-orange-600 dark:hover:border-orange-600 focus:outline-none focus:text-gray-700 dark:focus:text-gray-700 focus:bg-amber-400 dark:focus:bg-amber-400 focus:border-none dark:focus:border-none transition duration-150 ease-in-out';
            
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
