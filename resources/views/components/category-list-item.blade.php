<div class="media my-2">
    @if(!empty($category->thumbnail_path))
        <img src="{{ $category->thumbnail }}" class="mr-3" alt="{{ $content->title }}">
    @else
        <x-no-image :content="$content" />
    @endif
    <div class="media-body">
        <h5 class="mt-0"><a href="{{ route('categories.show', [app()->getLocale(), $content->url]) }}">{{ $content->title }}</a></h5>
        {!! Helper::stripTags($content->description) !!}
    </div>
</div>
