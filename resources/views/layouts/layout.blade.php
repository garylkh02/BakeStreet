<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bake Street</title>

        <div class="header">
        <header>
            <div class="logo">
                <img src="/img/logo.svg" alt="logo">
            </div>
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">{{ Auth::user()->name }}</a>
                        
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            
        </header>
        </div>
    


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
       <link href="/css/main.css" rel="stylesheet">

       @vite(['resources/scss/main.scss', 'resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body>
        @yield('content')
        

        <footer>
            Copyright 2024 Bake Street
        </footer>
    </body>
</html>
