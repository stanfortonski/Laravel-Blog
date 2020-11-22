<div class="media my-2">
    @if(!empty($category->thumbnail_path))
        <img src="{{ $category->thumbnail }}" class="mr-3" alt="{{ __($category->title) }}">
    @else
        <x-no-image :obj="$category" />
    @endif
    <div class="media-body">
        <h5 class="mt-0"><a href="{{ route('categories.show', $category->id) }}">{{ __($category->title) }}</a></h5>
        {!! Helper::stripTags(__($category->description)) !!}
    </div>
</div>
