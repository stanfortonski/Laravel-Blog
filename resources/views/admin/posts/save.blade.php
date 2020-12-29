@extends('layouts.admin')

@php $prefix = empty($post) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Post'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Post') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-2 text-right">
                    <x-choose-lang-admin />
                </div>

                @empty($post))
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                @endempty
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
                                @if(!empty($post) && !empty($post->thumbnail_path))
                                    <img class="img-fluid" src="{{ $post->thumbnail }}" alt="{{ $content->title }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_visible" name="is_visible" @if(!empty($post->is_visible) && $post->is_visible) checked @endif>
                            <label class="custom-control-label" for="is_visible">{{ __('visible') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-8">
                                <label for="publish_at_date">{{ __('Publish At Date') }}</label>
                                <input type="date" id="publish_at_date" name="publish_at_date" class="form-control">{{ !empty($post->publish_at) ? $post->publish_at->format('Y-m-d') : '' }}
                                @error('publish_at_date')
                                    <span class="form-text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="publish_at_time">{{ __('Publish At Time') }}</label>
                                <input type="time" id="publish_at_time" name="publish_at_time" class="form-control">{{ !empty($post->publish_at) ? $post->publish_at->format('H:i') : '' }}
                                @error('publish_at_time')
                                    <span class="form-text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        @empty($post))
                            <x-select-categories />
                        @else
                            <x-select-categories :value="Arr::flatten($post->categories()->pluck('id')->values()->toArray()) ?? null" />
                        @endempty
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $prefix }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(!empty($post))
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Delete') }} {{ __('Post') }}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __('Be careful when using this operation.') }}</p>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
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
