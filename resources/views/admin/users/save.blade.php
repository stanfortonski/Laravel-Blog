@extends('layouts.admin')

@php $prefix = empty($user) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Users') }}</span>
            </div>
            <div class="card-body">
                @if(empty($user))
                    <form action="{{ route('admin.users.store') }}" method="POST">
                @else
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @method('PUT')
                @endif
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name ?? '' }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}*</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email ?? '' }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="first_name">{{ __('first name') }}*</label>
                                <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name ?? ''}}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="last_name">{{ __('last name') }}*</label>
                                <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $user->last_name ?? '' }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('description') }}</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ $user->description ?? '' }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group @if(!empty($user)) d-none @endif" id="password-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if(!empty($user))
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="change_password" name="change_password">
                                <label class="custom-control-label" for="change_password">{{ __('Change Password') }}</label>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        @if(empty($user))
                            <x-select-roles />
                        @else
                            <x-select-roles :selected="Arr::flatten($user->roles()->pluck('id')->values()->toArray()) ?? null" />
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-8">
                                <x-input-thumbnail label="avatar"></x-input-thumbnail>
                            </div>
                            <div class="col-4">
                                @if(!empty($user) && !empty($user->thumbnail_path))
                                    <img class="img-fluid" src="{{ $user->avatar }}" alt="{{ $user->title }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">{{ $prefix }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

