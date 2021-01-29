<div class="card" itemprop="author" itemscope itemtype="http://schema.org/Person">
    <div class="card-body p-2">
        <div class="col">
            <figure class="author-figure">
                @if(!empty($author->thumbnail_path))
                    <img src="{{ $author->avatar }}" alt="{{ $author->full_name }} - {{ config('app.name') }}" itemprop="image" class="img-fluid" width="144" height="144">
                @endif
                <figcaption>{{ $author->full_name }}</figcaption>
            </figure>
            <span itemprop="description">{{ $content->description ?? '' }}</span>
            <p><a href="{{ route('author', [app()->getLocale(), $author->url]) }}">{{ __('Read More about author') }}</a></p>
        </div>
    </div>

    @if (!empty($author->website))
        <div class="card-footer">
            {{ __('Author\'s website') }}: <a href="{{ $author->website }}" itemprop="url">link</a>
        </div>
    @endif
</div>
<span class="d-none" itemprop="publisher" itemscope itemtype="http://schema.org/Person">
    <meta itemprop="name" content="{{ $author->full_name }}">
    <span itemprop="description">{{ $content->description ?? '' }}</span>
</span>
