<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords" content="@yield('keywords', 'Laravel, Blog, Better than WordPress')">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <link rel="icon shortcut" href="{{ asset('favicon.ico') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @auth <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}"> @endauth
    @stack('styles')
</head>
<body itemscope itemtype="http://schema.org/WebPage">
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
                            <ul class="navbar-nav mr-auto navbar-main" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                                <li class="nav-item" itemprop="hasPart">
                                    <a class="nav-link" itemprop="url" href="{{ route('index', app()->getLocale()) }}">Start</a>
                                </li>

                                <li class="nav-item dropdown" itemprop="hasPart">
                                    <a id="categoriesDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Categories') }}
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                        <a itemprop="url" class="dropdown-item" href="{{ route('categories.index', app()->getLocale()) }}">
                                            {{ __('All') }}
                                        </a>

                                        @foreach(App\Models\Category::with('content')->get() as $category)
                                            @php $content = $category->content()->first(); @endphp
                                            @if(!empty($content))
                                                <span itemprop="hasPart">
                                                    <a itemprop="url" class="dropdown-item" href="{{ route('categories.show', [app()->getLocale(), $content->url]) }}">
                                                        {{ __($content->title) }}
                                                    </a>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>

                                <li class="nav-item" itemprop="hasPart">
                                    <a itemprop="url" class="nav-link" href="{{ route('posts.index', app()->getLocale()) }}">{{ __('Posts') }}</a>
                                </li>
                            </ul>

                            <ul class="navbar-nav ml-auto">
                                @foreach (config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link mr-1 @if(app()->getLocale() == $locale) font-weight-bold @endif" href="{{ route('index', $locale) }}">{{ strtoupper($locale) }}</a>
                                    </li>
                                @endforeach

                                <form method="GET" action="{{ route('posts.index', app()->getLocale()) }}" class="form-inline my-2 my-lg-0">
                                    <input type="search" name="q" class="form-control mr-sm-2" placeholder="{{ __('Search') }}" aria-label="{{ __('Search') }}" value="{{ $q ?? '' }}">
                                    <button type="submit" class="btn btn-outline-secondary my-2 my-sm-0">{{ __('Search') }}</button>
                                </form>

                                @auth
                                    <li class="ml-2 nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ auth()->user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            @include('layouts.parts.menu')
                                        </div>
                                    </li>
                                @endauth
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
