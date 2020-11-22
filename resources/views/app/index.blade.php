@extends('layouts.app')

@section('title', config('app.name'))
@section('description', 'Laravel-Blog App')

@section('content')
<div class="row">
    <div class="col">
        <div class="jumbotron jumbotron-fluid px-5">
            <div class="container">
                <h1 class="display-3">{{ config('app.name') }}</h1>
                <p class="lead">{{ __('This is a Laravel-Blog App.') }}</p>
            </div>
        </div>
    </div>
</div>
@if($posts->count() > 0)
    <div class="row mt-5">
        <div class="col" itemscope itemtype="http://schema.org/Blog">
            <h3 class="text-center">{{ __('Random') }} {{ __('Posts') }}</h3>
            @foreach($posts as $post)
                <x-post-list-item :post="$post" />
            @endforeach
        </div>
    </div>
@endif
@if($categories->count() > 0)
    <div class="row mt-5">
        <div class="col">
            <h3 class="text-center">{{ __('Random') }} {{ __('Categories') }}</h3>
            @foreach($categories as $category)
                <x-category-list-item :category="$category" />
            @endforeach
        </div>
    </div>
@endif
@endsection
