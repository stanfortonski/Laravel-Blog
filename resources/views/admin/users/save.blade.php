@extends('layouts.admin')

@php $prefix = empty($user) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('User'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('User') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-2 text-right">
                    <x-choose-lang-admin />
                </div>

                @empty($user)
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                @endempty
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name ?? '' }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="first_name">{{ __('First Name') }}*</label>
                                <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name ?? '' }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="last_name">{{ __('Last Name') }}*</label>
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
                        <label for="email">{{ __('E-Mail Address') }}*</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email ?? '' }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @empty($user)
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}*</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endempty

                    <div class="form-group">
                        <label for="website">{{ __('website') }}</label>
                        <input type="text" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ $user->website ?? '' }}">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('content') }}</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror">{{ $content->content ?? '' }}</textarea>
                        @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        @empty($user)
                            <x-select-roles />
                        @else
                            <x-select-roles :value="Arr::flatten($user->roles()->pluck('id')->values()->toArray()) ?? null" />
                        @endempty
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-8">
                                <x-input-thumbnail label="avatar"></x-input-thumbnail>
                            </div>
                            <div class="col-4">
                                @if(!empty($user) && !empty($user->thumbnail_path))
                                    <span>{{ __('Current') }}</span>
                                    <img class="img-fluid mt-1" src="{{ $user->avatar }}" alt="Avatar">
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

@if(!empty($user))
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Change Password') }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.password', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary">{{ __('Change') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Delete') }} {{ __('User') }}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __('Be careful when using this operation.') }}</p>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

