@extends('layouts.app')

@section('title', $user->full_name)
@section('description', $content->description ?? '')

@section('content')
<div class="row">
    <div class="col-12">
        <figure class="figure-author">
            @if(!empty($user->thumbnail_path))
                <img src="{{ $user->avatar }}" alt="{{ $user->full_name }} - {{ config('app.name') }}" itemprop="image" class="img-fluid" width="144" height="144">
            @endif
            <figcaption><h1>{{ $user->full_name }}</h1></figcaption>
        </figure>
        <p>{{ $content->content ?? '' }}</p>
    </div>
</div>
@endsection
