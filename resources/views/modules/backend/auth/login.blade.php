@extends('layouts.backend.auth-app')

@section('title', $title)

@section('content')
    <div class="auth-logo">
        <a href="{{ route('login') }}"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
    </div>

    <h1 class="auth-title">Silahkan Masuk</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" class="form-control form-control-xl" placeholder="Username" name="email" required autofocus>
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" required>
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4" type="submit">Log in</button>
    </form>
@endsection
