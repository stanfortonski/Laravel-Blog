@extends('layouts.admin')

@php $prefix = empty($category) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Category'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    @if(!empty($content->url))
        <div class="col-lg-10 mb-3 text-right">
            <a href="{{ route('categories.show', [app()->getLocale(), $content->url]) }} " class="btn btn-secondary" target="_blank">{{ __('Show') }}</a>
        </div>
    @endif

    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Category') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-2 text-right">
                    <x-choose-lang-admin />
                </div>

                @empty($category)
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @method('PUT')
                @endempty
                    @csrf

                    <div class="form-group">
                        <label for="title">{{ __('title') }}*</label>
                        <input type="text" id="title" name="content[title]" class="form-control @error('content.title') is-invalid @enderror" value="{{ $content->title ?? old('content.title') }}" required>
                        @error('content.title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="url">{{ __('url') }}*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ url('/') }}/{{app()->getLocale()}}/categories/</span>
                            </div>
                            <input type="text" id="url" name="content[url]" class="form-control @error('content.url') is-invalid @enderror" value="{{ $content->url ?? old('content.url') }}" required>
                            @error('content.url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('content') }}*</label>
                        <textarea id="content" name="content[content]" class="textarea-ckeditor form-control @error('content.content') is-invalid @enderror">{{ $content->content ?? old('content.content') }}</textarea>
                        @error('content.content')
                            <span class="form-text text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @empty($category)
                        <div class="form-group">
                            <x-input-thumbnail label="thumbnail"></x-input-thumbnail>
                        </div>
                    @endempty

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $prefix }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(!empty($category))
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Thumbnail') }} {{ __('Category') }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.image.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-8">
                                    <x-input-thumbnail label="Thumbnail"></x-input-thumbnail>
                                </div>
                                @if(!empty($category->thumbnail_path))
                                    <div class="col-4">
                                        <span>{{ __('Current') }}</span>
                                        <img class="img-fluid my-1" src="{{ $category->thumbnail }}" alt="{{ $content->title }}">
                                        <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-thumbnail-form').submit();">{{ __('Delete exists thumbnail') }}</button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Upload new thumbnail') }}</button>
                    </form>

                    @if(!empty($category->thumbnail_path))
                        <form action="{{ route('admin.categories.image.destroy', $category->id) }}" method="POST" id="delete-thumbnail-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>

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
    @endif
</div>
@endsection
