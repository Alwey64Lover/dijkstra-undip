<li class="menu-item {{ routeIsActive('dashboard') }}">
    <a href="{{ route('dashboard') }}" class='menu-link'>
        <span><i class="bi bi-grid-fill"></i> Dashboard</span>
    </a>
</li>

@if (in_array(user()->role, ['superadmin', 'dean']))
    <li class="menu-item {{ routeIsActive('users.*') }}">
        <a href="{{ route('users.table') }}" class='menu-link'>
            <span><i class="bi bi-person-fill"></i> Users</span>
        </a>
    </li>
@endif

@if (in_array(user()->role, ['head_of_department']))
    <li class="menu-item {{ routeIsActive('schedule.*') }}">
        <a href="{{ route('schedule.table') }}" class='menu-link'>
            <span><i class="bi bi-journals"></i> Schedule</span>
        </a>
    </li>
    <li class="menu-item {{ routeIsActive('newsched.*') }}">
        <a href="{{ route('newschedule') }}" class='menu-link'>
            <span><i class="bi bi-journal-plus"></i> New Schedule</span>
        </a>
    </li>
    <li class="menu-item {{ routeIsActive('newcourses.*') }}">
        <a href="{{ route('newcourses') }}" class='menu-link'>
            <span><i class="bi bi-plus-square"></i> New Courses</span>
        </a>
    </li>
@endif

