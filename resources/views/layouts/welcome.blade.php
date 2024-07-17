<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bake Street') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
      
        <!-- Scripts -->
        @vite(['resources/scss/main.scss', 'resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        
    </head>

    <body class="font-sans antialiased">
        <div class="bg-amber-50" style="position: relative; z-index: 1000;">
        @include('homenav-menu')
        </div>
        <!-- Page Content -->
        <main style="position: relative; z-index: 0;">
            @yield('content')
        </main>

        @stack('modals')
        @livewireScripts
        <script>
            var myAccordion = new bootstrap.Collapse(document.getElementById('accordionPanelsStayOpenExample'), {
                toggle: false
            });
        </script>
    </body>
    @include('layouts.footer')
</html>

