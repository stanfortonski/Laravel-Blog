@extends('layouts.app')

@section('title', config('app.name'))
@section('description', __('This is a Laravel-Blog App.'))

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
                <x-post-item :post="$post" />
            @endforeach
        </div>
    </div>
@endif
@if($categories->count() > 0)
    <div class="row mt-5">
        <div class="col" itemscope itemtype="https://schema.org/ItemList">
            <h3 class="text-center">{{ __('Random') }} {{ __('Categories') }}</h3>
            @foreach($categories as $category)
                <meta itemprop="numberOfItems" content="{{$categories->count()}}">
                <meta itemprop="itemListOrder" content="Unordered">
                <x-category-item :category="$category" :index="$loop->index" />
            @endforeach
        </div>
    </div>
@endif
@endsection
