@extends('layouts.admin')

@section('title', __('Admin Panel'))

@section('content')
@if (!auth()->user()->two_factor_secret)
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
@endif

<div class="row justify-content-center">
    <div class="col-md-5 mb-4">
        <div class="card h-100 pt-3 pb-1">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{__('Posts')}}</div>
                        <h4 class="mb-0 font-weight-bold text-gray-800">{{ App\Models\Post::count() }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cubes fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 mb-4">
        <div class="card h-100 pt-3 pb-1">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{__('Categories')}}</div>
                        <h4 class="mb-0 font-weight-bold text-gray-800">{{ App\Models\Category::count() }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
