<div class="card" itemprop="author" itemscope itemtype="http://schema.org/Person">
    <div class="card-header">
        <strong class="card-title h5" itemprop="name">{{ $author->full_name }}</strong>
    </div>

    @if (!empty($author->content))
        <div class="card-body">
            @if(!empty($author->thumbnail_path))
                <div class="col-4">
                    <img src="{{ $author->thumbnail }}" alt="{{ $author->full_name }} - {{ config('app.name') }}" itemprop="image" class="img-fluid" width="144" height="144">
                </div>
            @endif
            <div class="@empty($author->thumbnail_path)) col-12 @else col-8 @endempty">
                <span itemprop="description">{{ $content->description ?? '' }}</span>
            </div>
        </div>
    @endif

    @if (!empty($author->website))
        <div class="card-footer">
            <span class="mx-1">{{ __('Author\'s website') }}: <a href="{{ $author->website }}" itemprop="url">link</a></span>
            <span class="mx-1">{{ __('About author') }}: <a href="{{ route('author', [app()->getLocale(), $author->url]) }}">link</a></span>
        </div>
    @endif
</div>
<span class="d-none" itemprop="publisher" itemscope itemtype="http://schema.org/Person">
    <meta itemprop="name" content="{{ $author->full_name }}">
    <span itemprop="description">{{ $content->description ?? '' }}</span>
</span>
