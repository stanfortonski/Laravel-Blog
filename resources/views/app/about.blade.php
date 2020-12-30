@extends('layouts.app')

@section('title', __('About'))
@section('description', __('About').' '.config('app.name'))

@section('content')
<div class="row">
    <div class="col">
        <div class="jumbotron jumbotron-fluid px-5">
            <div class="container">
                <h1 class="display-4">{{ __('About') }} Laravel-Blog</h1>
                <p class="lead">{{ __('This is Blog based on Laravel.') }}</p>
                <a class="btn btn-lg btn-primary" href="https://github.com/stanfortonski/Laravel-Blog">{{ __('Learn more') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
