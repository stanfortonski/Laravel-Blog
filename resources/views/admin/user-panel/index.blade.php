@extends('layouts.admin')

@section('title', __('User Panel'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('User Panel') }}</li>
@endsection

@section('content')
    @include('admin.user-panel.forms.data')
    @include('admin.user-panel.forms.password')
@endsection
