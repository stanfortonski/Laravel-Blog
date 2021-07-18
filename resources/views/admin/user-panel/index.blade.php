@extends('layouts.admin')

@section('title', __('User Panel'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('User Panel') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    @include('admin.user-panel.forms.data')
    @include('admin.user-panel.forms.password')
    @include('admin.user-panel.forms.avatar')
    @include('admin.user-panel.forms.twofactor')
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>$('#lfm').filemanager('image');</script>
@endpush
