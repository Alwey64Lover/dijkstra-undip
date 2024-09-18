<li class="menu-item  {{ routeIsActive('dashboard') }}">
    <a href="{{ route('dashboard') }}" class='menu-link'>
        <span><i class="bi bi-grid-fill"></i> Dashboard</span>
    </a>
</li>

<li class="menu-item  {{ routeIsActive('users.*') }}">
    <a href="{{ route('users.table') }}" class='menu-link'>
        <span><i class="bi bi-grid-fill"></i> Users</span>
    </a>
</li>

