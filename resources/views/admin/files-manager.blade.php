@extends('layouts.admin')

@section('title', __('Files Manager'))

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <iframe src="{{ route('admin.unisharp.lfm.show') }}" style="width: 100%; height: 600px; overflow: hidden; border: none;"></iframe>
        <a href="{{ route('admin.unisharp.lfm.show') }}" class="btn btn-primary my-4" target="_blank">{{ __('Open in new card') }}</a>
    </div>
</div>
@endsection
