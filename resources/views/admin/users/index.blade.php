@extends('layouts.admin')

@section('title', __('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">{{ __('Add User') }}</a>
        <div class="card mt-3">
            <div class="card-header">
                <span class="card-title h5">{{ __('Posts') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="pt-3 pb-2 px-4">
                    <x-search :q="$q" />
                </div>

                @if ($users->count() > 0)
                    <table class="table table-borderless table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Avatar') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Full Name') }}</th>
                                <th scope="col">{{ __('E-Mail Address') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>
                                        @if(!empty($user->thumbnail_path))
                                            <img class="img-fluid" src="{{ $user->avatar }}" alt="{{ $user->name }}" width="144" height="144">
                                        @else
                                            {{ __('No image') }}
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink-{{ $loop->iteration }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-{{ $loop->iteration }}">
                                                <a class="dropdown-item" href="{{ route('author', [app()->getLocale(), $user->url]) }}" target="_blank">{{ __('Show') }}</a>
                                                <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">{{ __('Edit') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h5 class="db-empty">{{ __('No users.') }}</h5>
                @endif
            </div>
            <div class="card-footer">
                {{ $users->appends($searchData)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
