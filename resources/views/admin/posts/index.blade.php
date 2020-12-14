@extends('layouts.admin')

@section('title', __('Posts'))

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Posts') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">{{ __('Add Post') }}</a>
        <div class="card mt-3">
            <div class="card-header">
                <span class="card-title h5">{{ __('Posts') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="pt-3 pb-2 px-4">
                    <x-search :q="$q" />
                </div>

                @if ($posts->count() > 0)
                    <table class="table table-borderless table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Categories') }}</th>
                                <th scope="col">{{ __('thumbnail') }}</th>
                                <th scope="col">{{ __('title') }}</th>
                                <th scope="col">{{ __('description') }}</th>
                                <th scope="col">{{ __('Author') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <th scope="row">{{ $post->id }}</th>
                                    <td><small>{{ implode(', ', $post->categories->pluck('title')->toArray()) }}</small></td>
                                    <td>
                                        @if(!empty($post->thumbnail_path))
                                            <img class="img-fluid" src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                                        @else
                                        {{ __('No image') }}
                                        @endif
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->author->full_name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink-{{ $loop->iteration }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-{{ $loop->iteration }}">
                                                <a class="dropdown-item" href="{{ route('posts.show', $post->id) }}">{{ __('Show') }}</a>
                                                <a class="dropdown-item" href="{{ route('admin.posts.edit', $post->id) }}">{{ __('Edit') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h5 class="db-empty">{{ __('No posts.') }}</h5>
                @endif
            </div>
            <div class="card-footer text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
