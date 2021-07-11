@foreach (config('blog.available_locales') as $locale)
    <a class="btn btn-sm m-1 @if (app()->getLocale() == $locale) btn-primary disabled @else btn-secondary @endif" href="{{ route('admin.set-lang', $locale) }}">{{ strtoupper($locale) }}</a>
@endforeach
