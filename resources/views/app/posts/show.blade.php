@extends('layouts.app')

@section('title', __($post->title))
@section('description', __($post->description))

@section('content')
<div class="row"  itemscope itemtype="http://schema.org/BlogPosting">
    <article class="col-12">
        <h1 itemprop="name">{{ __($post->title) }}</h1>
        <p itemprop="sdDatePublished">
            {{ __('Created At') }}: <time itemprop="dateCreated">{{ $post->created_at->format(config('blog.timestamp_format')) }}</time><br>
            {{ __('Updated At') }}: <time itemprop="dateModified">{{ $post->updated_at->format(config('blog.timestamp_format')) }}</time>
        </p>
        <span itemprop="articleBody">{!! Helper::stripTags(__($post->content)) !!}</span>
    </article>

    <div class="col-12 mt-5" itemprop="author">
        <x-author-note :author="$post->author" />
    </div>

    <div class="col mt-5">
        <div id="disqus_thread"></div>
    </div>
</div>
@endsection

@include('components.disqus', ['id' => $post->id])
