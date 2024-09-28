<div class="header-top">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo logo-md">
            <a href="index.html">
                <img src="{{ asset('storage/static/dijkstraLogo.png') }}" alt="Logo" style="height: 78px; width: auto; margin:-22px; margin-left: 15px">
            </a>
        </div>
        <div class="header-top-right">
            <div class="dropdown">
                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar avatar-md2">
                        <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                    </div>
                    <div class="text">
                        <h6 class="user-dropdown-name">{{ user()->name }}</h6>
                        <p class="user-dropdown-status text-sm text-muted">{{ config('roles.'.user()->role) }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                    <li>
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_logout">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>

            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </div>
    </div>
</div>

<nav class="main-navbar">
    <div class="container">
        <ul>
            @include('layouts.backend.item-menu')
        </ul>
    </div>
</nav>
