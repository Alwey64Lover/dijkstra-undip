@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
    <style>
        #auth-right img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('body')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    @yield('content')
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block" style="height: 100%;">
                <div id="auth-right">
                    <img src="{{ asset('storage/static/fsm.jpg') }}" alt="Responsive image">
                </div>
            </div>
        </div>
    </div>
@endsection
