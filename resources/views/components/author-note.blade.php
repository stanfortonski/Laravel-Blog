<div class="card">
    <div class="card-header">
        <strong class="card-title">{{ __('Author') }}</strong>
    </div>
    <div class="card-body" itemscope itemtype="http://schema.org/Person">
        @if(!empty($author->thumbnail_path))
            <div class="col-4">
                <img src="{{ $author->thumbnail }}" alt="{{ $author->full_name }} - {{ config('app.name') }}" itemprop="image">
            </div>
        @endif
        <div class="@if(empty($author->thumbnail_path)) col-12 @else col-8 @endif">
            <h5 itemprop="name">{{ $author->full_name }}</h5>
            <span itemprop="description">{{ $author->content()->first()->description ?? '' }}</span>
        </div>
    </div>
    @if (!empty($author->website))
        <div class="card-footer">
            <span class="mx-1">{{ __('Author\'s website') }}: <a href="{{ $author->website }}" itemprop="url">link</a></span>
            <span class="mx-1">{{ __('About author') }}: <a href="{{ route('author', [app()->getLocale(), $author->url]) }}">link</a></span>
        </div>
    @endif
</div>
