@extends('layouts.app')

@section('title', __('errors.403.title'))
@section('description', __('errors.403.description'))

@section('content')
    <h1>{{ __('errors.403.title') }} | 403</h1>
    <p>{{ __('errors.403.description') }}</p>
    <p>
        <a href="{{ route('index', app()->getLocale()) }}" class="btn btn-primary">
            {{ __('Back to Main Page') }}
        </a>
    </p>
@endsection
