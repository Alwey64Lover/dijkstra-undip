@extends('layouts.base')

@section('body')
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                @include('layouts.backend.navbar')
            </header>

            <div class="content-wrapper container">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>

            {{-- <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2023 &copy; Mazer</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="https://saugi.me">Saugi</a></p>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>

    <x-modal.modal-logout/>
@endsection
