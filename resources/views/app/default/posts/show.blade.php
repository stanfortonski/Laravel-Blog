@extends('layouts.app')

@section('title', $content->title)
@section('description', strip_tags($content->description))
@section('keywords', $post->tags)

@section('content')
<div class="row" itemscope itemtype="http://schema.org/BlogPosting">
    @auth
        @if (auth()->user()->hasRole('admin') || auth()->user()->id == $post->author_id)
            <div class="col-12 mb-3 text-right">
                <a href="{{ route('admin.posts.edit', $post->id) }} " class="btn btn-secondary">Edytuj</a>
            </div>
        @endif
    @endauth

    <article class="article col-12">
        <div class="article-header">
            @if(!empty($post->thumbnail_path))
                <meta itemprop="thumbnailUrl" src="{{ $post->thumbnail }}">
                <div itemprop="image" itemscope itemtype="http://schema.org/ImageObject" style="min-width:300px">
                    <img itemprop="url" src="{{ $post->thumbnail }}" alt="{{ $content->title }}" width="300" height="300">
                </div>
            @else
                <x-no-image :content="$content" width="300" height="300" />
            @endif
            <div class="text-dark p-3">
                <h1 itemprop="name">{{ $content->title }}</h1>
                <meta itemprop="headline" content="{{ $content->title }}">
                <p>
                    <meta itemprop="dateCreated" content="{{ $content->created_at->format(config('blog.timestamp_format')) }}">
                    <span class="mr-1">{{ __('Created At') }}: <time itemprop="datePublished">{{ $content->created_at->format(config('blog.timestamp_format')) }}</time></span>
                    <span>{{ __('Updated At') }}: <time itemprop="dateModified">{{ $content->updated_at->format(config('blog.timestamp_format')) }}</time></span>
                </p>
                <p itemprop="about">{{ strip_tags($content->description) }}</p>
                <meta itemprop="description" content="{{ strip_tags($content->description) }}">
            </div>
        </div>
        <div class="article-body mt-4 p-4" itemprop="articleBody">
            {!! Helper::stripTags($content->content) !!}
        </div>
    </article>

    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body p-2">
                {{ __('Tags') }}: {{ $post->tags }}
            </div>
        </div>
    </div>

    <div class="col-12 mt-2">
        <x-author-note :author="$post->author" />
    </div>

    <div class="col-12 mt-5">
        <div id="disqus_thread"></div>
    </div>
</div>
@endsection

@include('components.disqus', ['id' => $content->id])
