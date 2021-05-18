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
    <script src="{{ asset('js/admin.js') }}" defer></script>
    @stack('scripts')

    <link rel="icon shortcut" href="{{ asset('favicon.ico') }}">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    @stack('styles')
</head>
<body>
    <div id="app" class="c-app">
        <aside class="c-sidebar c-sidebar-dark c-sidebar-show">
            <ul class="c-sidebar-nav">
                <li class="c-sidebar-nav-title text-center">{{ __('Dashboard') }} {{ config('app.name') }}</li>

                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.index') }}">
                        <i class="mr-3 fas fa-home"></i> Start
                    </a>
                </li>

                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                        <i class="mr-3 fas fa-users"></i> {{ __('Users') }}
                    </a>
                </li>

                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.posts.index') }}">
                        <i class="mr-3 fas fa-cubes"></i> {{ __('Posts') }}
                    </a>
                </li>

                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.categories.index') }}">
                        <i class="mr-3 fas fa-book"></i> {{ __('Categories') }}
                    </a>
                </li>
            </ul>
            <button class="c-sidebar-minimizer c-brand-minimizer" type="button"></button>
        </aside>

        <div class="c-wrapper">
            <header class="c-header c-header-light">
                <button class="navbar-toggler sidebar-toggler" type="button">
                    <i class="sidebar-toggler-icon"></i>
                </button>

                <a class="ml-4 c-header-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>

                <ul class="c-header-nav ml-auto text-right justify-content-end mr-3">
                    @foreach (config('app.available_locales') as $locale)
                        <li class="nav-item">
                            <a class="nav-link p-1 @if (app()->getLocale() == $locale) disabled @endif" href="{{ route('admin.set-lang', $locale) }}">{{ strtoupper($locale) }}</a>
                        </li>
                    @endforeach |

                    <li class="c-header-nav-item dropdown">
                        <a id="navbarDropdown" class="c-header-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @include('layouts.parts.menu')
                        </div>
                    </li>
                </ul>
            </header>

            <div class="c-body">
                <nav class="col-12 p-0" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}">Admin</a>
                        </li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>

                <main class="c-main">
                    <div class="@yield('container-fluid', 'container')">
                        @include('components.alert')
                        @yield('content')
                    </div>
                </main>
            </div>

            @include('components.noscript')
            @include('layouts.parts.footer-admin')
        </div>
    </div>
</body>
</html>
