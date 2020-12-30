@extends('layouts.app')

@section('title', $user->full_name)
@section('description', $content->description ?? '')

@section('content')
<div class="row">
    @if (!empty($user->thumbnail_path))
        <div class="col-4">
            <img class="img-fluid" src="{{ $user->avatar }}" alt="{{ $user->full_name }}" width="144" height="144">
        </div>
    @endif
    <div class="@empty($user->thumbnail_path)) col-12 @else col-8 @endempty">
        <h1>{{ $user->full_name }}</h1>
        {{ $content->content ?? '' }}
    </div>
</div>
@endsection
