@extends('layouts.app')

@section('title', $content->title)
@section('description', Helper::stripTags($content->description))

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h1>{{ $content->title }}</h1>
        {!! Helper::stripTags($content->description) !!}
    </div>
    <div class="col-12" itemscope itemtype="http://schema.org/Blog">
        @foreach($posts as $post)
            <x-post-list-item :post="$post" />
        @endforeach
    </div>
</div>
{{ $posts->links() }}
@endsection

