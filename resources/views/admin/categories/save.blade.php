@extends('layouts.admin')

@php $prefix = empty($user) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Categories'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Categories') }}</span>
            </div>
            <div class="card-body">
                @if(empty($user))
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                @else
                    <form action="{{ route('admin.categories.update', $user->id) }}" method="POST">
                    @method('PUT')
                @endif
                    @csrf

                    <div class="form-group">
                        <label for="title">{{ __('title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $category->title ?? '' }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('description') }}*</label>
                        <textarea id="description" name="description" class="textarea-ckeditor form-control">{{ $category->description ?? '' }}</textarea>
                        @error('description')
                            <span class="form-text text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-8">
                                <x-input-thumbnail label="thumbnail"></x-input-thumbnail>
                            </div>
                            <div class="col-4">
                                @if(!empty($category) && !empty($category->thumbnail_path))
                                    <img class="img-fluid" src="{{ $category->thumbnail }}" alt="{{ $category->title }}">
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
