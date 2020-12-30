<div class="media my-3 p-3 bg-white" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <meta itemprop="position" content="{{ $index }}">
    <meta itemprop="url" content="{{ route('categories.show', [app()->getLocale(), $content->url]) }}">
    @if(!empty($category->thumbnail_path))
        <img src="{{ $category->thumbnail }}" class="img-fluid mr-3" alt="{{ $content->title }} - {{ config('app.name') }}" itemprop="image" width="144" height="144">
    @else
        <x-no-image :content="$content" />
    @endif
    <div class="media-body">
        <h5 class="mt-0">
            <a href="{{ route('categories.show', [app()->getLocale(), $content->url]) }}">
                <span itemprop="name">{{ $content->title }}</span>
            </a>
        </h5>
        <span itemprop="description">{!! Helper::stripTags($content->description) !!}</span>
    </div>
</div>
