<div class="card" itemprop="author" itemscope itemtype="http://schema.org/Person">
    <div class="card-body py-2 px-0">
        <div class="col">
            <figure class="figure-author">
                @if(!empty($author->thumbnail_path))
                    <img src="{{ $author->avatar }}" alt="{{ $author->full_name }} - {{ config('app.name') }}" itemprop="image" class="img-fluid" width="144" height="144">
                @endif
                <figcaption class="ml-3">
                    <h5 itemprop="name">{{ $author->full_name }}</h5>
                    <span itemprop="description">{{ $content->description ?? 'dassssssssssssssssssssssssssssss' }}</span>
                </figcaption>
            </figure>
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
