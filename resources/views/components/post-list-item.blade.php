<article class="media my-2" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
    @if(!empty($post->thumbnail_path))
        <img src="{{ $post->thumbnail }}" class="mr-3" alt="{{ __($post->title) }}" itemprop="image">
    @else
        <x-no-image :obj="$post" />
    @endif
    <div class="media-body">
        <h5 class="mt-0" itemprop="name">{{ __($post->title) }}</h5>
        <p>
            {{ __('Published At') }}: <span itemprop="sdDatePublished" itemscope="Date">
                <span itemprop="dateCreated">{{ $post->created_at->format(config('blog.timestamp_format')) }}</span>
                <meta itemprop="dateModified" content="{{ $post->updated_at->format(config('blog.timestamp_format')) }}">
            </span><br>
            {{ __('Author') }}: <span itemprop="author">{{ $post->author->full_name }}</span>
        </p>
        <span itemprop="articleBody">{!! Helper::stripTags(__($post->description)) !!}</span>
        <p><a href="{{ route('posts.show', $post->url) }}">{{ __('Read More') }}</a></p>
    </div>
</article>
