<article class="media my-3 p-3" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
    @if(!empty($post->thumbnail_path))
        <div itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
            <img itemprop="url" src="{{ $post->thumbnail }}" class="img-fluid mr-3" alt="{{ $content->title }} - {{ config('app.name') }}" width="144" height="144">
        </div>
        <meta itemprop="thumbnailUrl" src="{{ $post->thumbnail }}">
    @else
        <x-no-image :content="$content" />
    @endif
    <div class="media-body">
        <h5 class="mt-0">
            <a href="{{ route('posts.show', [app()->getLocale(), $content->url]) }}">
                <span itemprop="name">{{ $content->title }}</span>
            </a>
        </h5>
        <meta itemprop="headline" content="{{ $content->title }}">
        <p>
            {{ __('Published At') }}: <span itemprop="sdDatePublished" itemscope="Date">
                <meta itemprop="dateCreated" content="{{ $content->created_at->format(config('blog.timestamp_format')) }}">
                <span itemprop="datePublished">{{ $content->created_at->format(config('blog.timestamp_format')) }}</span>
                <meta itemprop="dateModified" content="{{ $content->updated_at->format(config('blog.timestamp_format')) }}">
            </span><br>
            {{ __('Author') }}: <span itemprop="author">{{ $post->author->full_name }}</span>
        </p>
        <span itemprop="articleBody">{{ $content->description }}</span>
        <p><a href="{{ route('posts.show', [app()->getLocale(), $content->url]) }}">{{ __('Read More') }}</a></p>
    </div>
</article>
