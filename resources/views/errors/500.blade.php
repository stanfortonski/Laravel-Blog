@extends('layouts.app')

@section('title', __('errors.500.title'))
@section('description', __('errors.500.description'))

@section('content')
    <h1>{{ __('errors.500.title') }} | 500</h1>
    <p>{{ __('errors.500.description') }}</p>
@endsection
