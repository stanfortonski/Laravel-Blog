<footer class="c-footer mt-auto">
    <div>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about', app()->getLocale()) }}">{{ __('About') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('privacy-policy', app()->getLocale()) }}">{{ __('Privacy Policy') }}</a>
            </li>
        </ul>
    </div>
    <div class="ml-auto">
        <a href="https://github.com/stanfortonski/Laravel-Blog">Stan Fortoński/{{ config('app.name') }}</a> &copy; {{ now()->year }}
    </div>
</footer>
