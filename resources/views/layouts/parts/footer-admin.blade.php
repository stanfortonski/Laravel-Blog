<footer class="c-footer mt-auto" itemscope itemtype="http://schema.org/WPFooter">
    <div>
        <ul class="nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
            <li class="nav-item" itemprop="hasPart">
                <a itemprop="url" class="nav-link" href="{{ route('privacy-policy', app()->getLocale()) }}">{{ __('Privacy Policy') }}</a>
            </li>

            <li class="nav-item" itemprop="hasPart">
                <a itemprop="url" class="nav-link" href="{{ route('about', app()->getLocale()) }}">{{ __('About') }}</a>
            </li>
        </ul>
    </div>
    <div class="ml-auto">
        <a href="https://github.com/stanfortonski/Laravel-Blog">Stan Fortoński/{{ config('app.name') }}</a> &copy; <span itemprop="copyrightYear">{{ now()->year }}</span>
    </div>
</footer>
