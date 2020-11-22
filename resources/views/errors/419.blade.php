@extends('layouts.app')

@section('title', __('errors.419.title'))
@section('description', __('errors.419.description'))

@section('content')
    <h1>{{ __('errors.419.title') }} | 419</h1>
    <p>{{ __('errors.419.description') }}</p>
    <p>
        <a href="{{ route('index') }}" class="btn btn-primary">
            {{ __('Back to Main Page') }}
        </a>
    </p>
@endsection
