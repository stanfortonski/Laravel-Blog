@extends('layouts.app')

@section('title', __('errors.405.title'))
@section('description', __('errors.405.description'))

@section('content')
    <h1>{{ __('errors.405.title') }} | 405</h1>
    <p>{{ __('errors.405.description') }}</p>
    <p>
        <a href="{{ route('index') }}" class="btn btn-primary">
            {{ __('Back to Main Page') }}
        </a>
    </p>
@endsection
