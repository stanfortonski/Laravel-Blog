@extends('layouts.admin')

@php $prefix = empty($category) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Category'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Category') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-2 text-right">
                    <x-choose-lang-admin />
                </div>

                @if(empty($category))
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                @endif
                    @csrf

                    <div class="form-group">
                        <label for="title">{{ __('title') }}*</label>
                        <input type="text" id="title" name="content[title]" class="form-control @error('content.title') is-invalid @enderror" value="{{ $content->title ?? '' }}" required>
                        @error('content.title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('content') }}*</label>
                        <textarea id="content" name="content[content]" class="textarea-ckeditor form-control  @error('content.content') is-invalid @enderror">{{ $content->content ?? '' }}</textarea>
                        @error('content.content')
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
                                    <img class="img-fluid" src="{{ $category->thumbnail }}" alt="{{ $content->title }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $prefix }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(!empty($category))
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Delete') }} {{ __('Category') }}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __('Be careful when using this operation.') }}</p>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
