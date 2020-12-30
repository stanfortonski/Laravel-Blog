@extends('layouts.admin')

@section('title', __('Categories'))

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Categories') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">{{ __('Add Category') }}</a>
        <div class="card mt-3">
            <div class="card-header">
                <span class="card-title h5">{{ __('Categories') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="pt-3 pb-2 px-4">
                    <x-search :q="$q" />
                </div>

                @if ($categories->count() > 0)
                    <table class="table table-borderless table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('thumbnail') }}</th>
                                <th scope="col">{{ __('title') }}</th>
                                <th scope="col">{{ __('description') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                @php $content = $category->content()->first(); @endphp
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>
                                        @if(!empty($category->thumbnail_path))
                                            <img class="img-fluid" src="{{ $category->thumbnail }}" alt="{{ $content->title ?? '' }}" width="144" height="144">
                                        @else
                                            {{ __('No image') }}
                                        @endif
                                    </td>
                                    <td>{{ $content->title ?? '' }}</td>
                                    <td>{!! Helper::stripTags($content->description ?? '') !!}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink-{{ $loop->iteration }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-{{ $loop->iteration }}">
                                                @isset($content->url)
                                                    <a class="dropdown-item" href="{{ route('categories.show', [app()->getLocale(), $content->url]) }}" target="_blank">{{ __('Show') }}</a>
                                                @endisset
                                                <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">{{ __('Edit') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h5 class="db-empty">{{ __('No categories.') }}</h5>
                @endif
            </div>
            <div class="card-footer text-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
