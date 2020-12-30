<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords" content="@yield('keywords', 'Laravel, Blog, Better than WordPress')">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex,nofollow">

    <title>{{ config('app.name') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <link rel="icon shortcut" href="{{ asset('favicon.ico') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div id="app" class="c-app">
        <div class="c-wrapper">
            <header class="c-header c-header-dark">
                <nav class="w-100 navbar navbar-expand-md navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name') }}
                        </a>
                    </div>
                </nav>
            </header>

            <div class="c-body">
                <main class="c-main">
                    <div class="@yield('container', 'container')">
                        @include('components.alert')
                        @yield('content')
                    </div>
                </main>
            </div>

            @include('components.noscript')
            @include('layouts.parts.footer')
        </div>
    </div>
</body>
</html>
