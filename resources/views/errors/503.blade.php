@extends('layouts.app')

@section('title', __('errors.503.title'))
@section('description', __('errors.503.description'))

@section('content')
    <h1>{{ __('errors.503.title') }}</h1>
    <p>{{ __('errors.503.description') }}</p>
@endsection
