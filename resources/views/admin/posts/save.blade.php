@extends('layouts.admin')

@php $prefix = empty($user) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Posts'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Posts') }}</span>
            </div>
            <div class="card-body">
                @if(empty($user))
                    <form action="{{ route('admin.posts.store') }}" method="POST">
                @else
                    <form action="{{ route('admin.posts.update', $user->id) }}" method="POST">
                    @method('PUT')
                @endif
                    @csrf

                    <div class="form-group">
                        <label for="title">{{ __('title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $post->title ?? '' }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('content') }}*</label>
                        <textarea id="content" name="content" class="textarea-ckeditor form-control">{{ $post->content ?? '' }}</textarea>
                        @error('content')
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
                                    <img class="img-fluid" src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_visible" name="is_visible">
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
                        @if(empty($user))
                            <x-select-categories />
                        @else
                            <x-select-categories :selected="Arr::flatten($post->categories()->pluck('id')->values()->toArray()) ?? null" />
                        @endif
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
