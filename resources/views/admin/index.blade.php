@extends('layouts.admin')

@section('title', __('Admin Panel'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <x-two-factor-manage />
        </div>
    </div>
@endsection
