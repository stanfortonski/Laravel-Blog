@extends('layouts.admin')

@php $prefix = empty($post) ? __('Create') : __('Edit'); @endphp
@section('title', $prefix.__('Post'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $prefix }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    @if(!empty($content->url))
        <div class="col-lg-10 mb-3 text-right">
            <a href="{{ route('posts.show', [app()->getLocale(), $content->url]) }}" class="btn btn-secondary" target="_blank">{{ __('Show') }}</a>
        </div>
    @endif

    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ $prefix }} {{ __('Post') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-2 text-right">
                    <x-choose-lang-admin />
                </div>

                @empty($post)
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
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
                                <span class="input-group-text">{{ url('/') }}/{{app()->getLocale()}}/posts/</span>
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
                        <textarea id="content" name="content[content]" class="form-control  @error('content.content') is-invalid @enderror">{{ $content->content ?? old('content.content') }}</textarea>
                        @error('content.content')
                            <span class="form-text text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @empty($post)
                        <div class="form-group">
                            <x-input-thumbnail label="thumbnail"></x-input-thumbnail>
                        </div>
                    @endempty

                    <div class="form-group">
                        @empty($post)
                            <x-select-categories />
                        @else
                            <x-select-categories :value="Arr::flatten($post->categories()->pluck('id')->values()->toArray()) ?? null" />
                        @endempty
                    </div>

                    <div class="form-group">
                        <label for="tags">{{ __('Tags') }}</label>
                        <input type="text" id="tags" name="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ $post->tags ?? old('tags') }}">
                        @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_visible" name="is_visible" @if(!empty($post->is_visible) && $post->is_visible) checked @endif>
                            <label class="custom-control-label" for="is_visible">{{ __('visible') }}</label>
                        </div>
                    </div>

                    <div id="release-inputs">
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
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $prefix }}</button>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($post))
            <div class="card mt-4">
                <div class="card-header">
                    <span class="card-title h5">{{ __('Thumbnail') }} {{ __('Post') }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{ route('admin.posts.image.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <x-input-thumbnail label="Thumbnail"></x-input-thumbnail>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('Upload new thumbnail') }}</button>
                                </div>
                            </form>
                        </div>

                        @if(!empty($post->thumbnail_path))
                            <div class="col-md-4">
                                <form action="{{ route('admin.posts.image.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="form-group">
                                        <span>{{ __('Current') }}</span>
                                        <img class="img-fluid my-1" src="{{ $post->thumbnail }}" alt="{{ $content->title }}">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">{{ __('Delete exists thumbnail') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-4">
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
        @endif
    </div>
</div>
@endsection
