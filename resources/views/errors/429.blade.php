@extends('layouts.app')

@section('title', __('errors.429.title'))
@section('description', __('errors.429.description'))

@section('content')
    <h1>{{ __('errors.429.title') }} | 429</h1>
    <p>{{ __('errors.429.description') }}</p>
    <p>
        <a href="{{ route('index', app()->getLocale()) }}" class="btn btn-primary">
            {{ __('Back to Main Page') }}
        </a>
    </p>
@endsection
