@extends('layouts.base')

@section('body')
    <div id="app">
        <div id="sidebar">
            @include('layouts.backend.sidebar')
        </div>

        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
                @include('layouts.backend.navbar')
            </header>

            <div id="main-content">
                <div class="page-heading">
                    @yield('content')
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>

                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <x-modal.modal-logout/>
@endsection
