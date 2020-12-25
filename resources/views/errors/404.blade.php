@extends('layouts.app')

@section('title', __('errors.404.title'))
@section('description', __('errors.404.description'))

@section('content')
    <h1>{{ __('errors.404.title') }} | 404</h1>
    <p>{{ __('errors.404.description') }}</p>
    <p>
        <a href="{{ route('index', app()->getLocale()) }}" class="btn btn-primary">
            {{ __('Back to Main Page') }}
        </a>
    </p>
@endsection
