@extends('layouts.admin')

@section('title', __('Admin Panel'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">{{ __('Two Factor Authentication') }}</div>
                <div class="card-body">
                    <x-two-factor-manage />
                </div>
            </div>
        </div>
    </div>
@endsection
