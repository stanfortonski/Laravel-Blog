@extends('layouts.admin')

@section('title', __('Admin Panel'))

@section('content')
    <div class="row">
        <div class="col-12">
            <x-two-factor-manage />
        </div>
    </div>
@endsection
