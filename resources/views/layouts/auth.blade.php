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
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div id="app" class="c-app">
        <div class="c-wrapper">
            <header class="c-header c-header-dark" itemscope itemtype="http://schema.org/WPHeader">
                <nav class="w-100 navbar navbar-expand-md navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ url('/') }}" itemprop="name">
                            {{ config('app.name') }}
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav mr-auto navbar-main">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('index', app()->getLocale()) }}">{{ __('Back to main page') }}</a>
                                </li>
                            </ul>

                            <ul class="navbar-nav ml-auto">
                                @foreach (config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link p-1 @if (app()->getLocale() == $locale) font-weight-bold @endif" href="{{ route('admin.set-lang', $locale) }}">{{ strtoupper($locale) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
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
