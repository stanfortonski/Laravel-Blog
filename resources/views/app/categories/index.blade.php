@extends('layouts.app')

@section('title', __('Categories'))
@section('description', __('Categories').' '.__('in').' '.config('app.name'))

@section('content')
<div class="row">
    <div class="col text-center">
        <h1>{{ __('Categories') }}</h1>
    </div>
</div>
<div class="row">
    <div class="col-12" itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="numberOfItems" content="{{$categories->total()}}">
        <meta itemprop="itemListOrder" content="Unordered">
        @foreach($categories as $category)
            <x-category-list-item :category="$category" :index="$loop->index" />
        @endforeach
    </div>
    <div class="col-12">
        {{ $categories->appends($searchData)->links() }}
    </div>
</div>
@endsection
