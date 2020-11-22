@extends('layouts.app')

@section('title', $user->full_name)
@section('description', __($user->description))

@section('content')
<div class="row">
    @if (!empty($user->thumbnail_path))
        <div class="col-4">
            <img class="img-fluid" src="{{ $user->avatar }}" alt="{{ $user->full_name }}">
        </div>
    @endif
    <div class="@if(empty($user->thumbnail_path)) col-12 @else col-8 @endif">
        <h1>{{ $user->full_name }}</h1>
        {{ __($user->description) }}
    </div>
</div>
@endsectio
n
