<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if (session('success'))
        <meta name="session-success" content="{{ session('success') }}">
    @endif

    @if (session('error'))
        <meta name="session-error" content="{{ session('error') }}">
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <meta name="session-errors[]" content="{{ $error }}">
        @endforeach
    @endif

    <title>@yield('title') | Template Mazer</title>

    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/helpers/helpers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">

    @stack('css')
</head>

<body>
    @yield('body')

    <script src="{{asset('assets/static/js/initTheme.js')}}"></script>
    <script src="{{asset('assets/static/js/components/dark.js')}}"></script>
    <script src="{{asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

    <script src="{{asset('assets/compiled/js/app.js')}}"></script>

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>

    @stack('js')

    <script src="{{ asset('assets/helpers/helpers.js') }}"></script>
</body>

</html>
