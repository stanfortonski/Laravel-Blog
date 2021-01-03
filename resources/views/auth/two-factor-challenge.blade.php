@extends('layouts.auth')

@section('title', __('Two Factor Authentication'))
@section('description', __('Two Factor Authentication').' - '.__('access to panel'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card">
                <div class="card-header text-center h3">
                    {{ __('Two Factor Authentication') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <p class="text-muted">
                            {{ __('Please enter your 2FA code.') }}
                        </p>

                        <div class="form-group">
                            <input name="code" type="text" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ __('Code') }}">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $errors->first('code') }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
