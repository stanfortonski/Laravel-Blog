@extends('layouts.app')

@section('title', $content->title)
@section('description', strip_tags($content->description))

@section('content')
<div class="row">
    <div class="col-12 text-center" itemscope itemtype="http://schema.org/Thing">
        <h1 itemprop="name">{{ $content->title }}</h1>
        @if(!empty($category->thumbnail_path))
            <div itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                <meta itemprop="url" content="{{ $category->thumbnail }}">
            </div>
        @endif
        <span itemprop="description">{!! Helper::stripTags($content->description) !!}</span>
    </div>
    <div class="col-12" itemscope itemtype="http://schema.org/Blog">
        @foreach($posts as $post)
            <x-post-list-item :post="$post" />
        @endforeach
    </div>
    <div class="col-12">
        {{ $posts->links() }}
    </div>
</div>
@endsection

