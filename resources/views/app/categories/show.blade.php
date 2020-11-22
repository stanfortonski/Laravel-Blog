@extends('layouts.app')

@section('title', __($category->title))
@section('description', __($category->description))

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h1>{{ __($category->title) }}</h1>
        {!! Helper::stripTags(__($category->description)) !!}
    </div>
    <div class="col-12" itemscope itemtype="http://schema.org/Blog">
        @foreach($posts as $post)
            <x-post-list-item :post="$post" />
        @endforeach
    </div>
</div>
{{ $posts->links() }}
@endsection

