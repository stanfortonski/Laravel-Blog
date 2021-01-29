@extends('layouts.app')

@section('title', $user->full_name)
@section('description', $content->description ?? '')

@section('content')
<div class="row">
    <div class="col-12">
        @if(!empty($user->thumbnail_path))
            <img src="{{ $user->avatar }}" alt="{{ $user->full_name }} - {{ config('app.name') }}" itemprop="image" class="img-fluid m-2" width="144" height="144" style="vertical-align: top;">
        @endif
        <div class="d-inline-block">
            <h1 style="display: inline;">{{ $user->full_name }}</h1><br>
            {{ $content->content ?? '' }}
        </div>
    </div>
</div>
@endsection
