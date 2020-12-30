@extends('layouts.app')

@section('title', __('Posts'))
@section('description', __('Posts').' '.__('in').' '.config('app.name'))

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h1>{{ __('Posts') }}</h1>
    </div>
    <div class="col-12" itemscope itemtype="http://schema.org/Blog">
        @foreach($posts as $post)
            <x-post-list-item :post="$post" />
        @endforeach
    </div>
    {{ $posts->links() }}
</div>
@endsection
