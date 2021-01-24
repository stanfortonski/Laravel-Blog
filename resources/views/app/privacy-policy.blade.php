@extends('layouts.app')

@section('title', __('Privacy Policy'))
@section('description', __('Privacy Policy').' '.__('in').' Laravel-Blog')

@section('content')
<div class="row">
    <div class="col">
        <h1>{{ __('Privacy Policy') }}</h1>
        {{ __('Your Policy.') }}
    </div>
</div>
@endsection
