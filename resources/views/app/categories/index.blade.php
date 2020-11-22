@extends('layouts.app')

@section('title', __('Categories'))

@section('content')
<div class="row">
    <div class="col text-center">
        <h1>{{ __('Categories') }}</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach($categories as $category)
            <x-category-list-item :category="$category" />
        @endforeach
    </div>
</div>
{{ $categories->links() }}
@endsection
