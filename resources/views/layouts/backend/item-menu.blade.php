<li class="menu-item {{ routeIsActive('dashboard') }}">
    <a href="{{ route('dashboard') }}" class='menu-link'>
        <span><i class="bi bi-grid-fill"></i> Dashboard</span>
    </a>
</li>

@if (in_array(user()->role, ['dean']))
    {{-- <li class="menu-item {{ routeIsActive('users.*') }}">
        <a href="{{ route('users.table') }}" class='menu-link'>
            <span><i class="bi bi-person-fill"></i> Users</span>
        </a>
    </li> --}}
    <li class="menu-item {{ routeIsActive('department-schedule.*') }}">
        <a href="{{ route('department-schedule.index') }}" class='menu-link'>
            <span><i class="bi bi-person-fill"></i> Department Schedule</span>
        </a>
    </li>

    <li class="menu-item {{ routeIsActive('academic-room.*') }}">
        <a href="{{ route('academic-room.index') }}" class='menu-link'>
            <span><i class="bi bi-person-fill"></i> Academic Room</span>
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
    <li class="menu-item {{ routeIsActive('courses.*') }}">
        <a href="{{ route('courses') }}" class='menu-link'>
            <span><i class="bi bi-plus-square"></i> Courses</span>
        </a>
    </li>
@endif

@if (in_array(user()->role, ['academic_division']))
    <li class="menu-item {{ routeIsActive('rooms.*') }}">
        <a href="{{ route('room.index') }}" class='menu-link'>
            <span><i class="bi bi-plus-circle"></i> Room</span>
        </a>
    </li>
    {{-- <li class="menu-item {{ routeIsActive('index.*') }}">
        <a href="{{ route('add-room') }}" class='menu-link'>
            <span><i class="bi bi-plus-circle"></i> New Room</span>
        </a>
    </li> --}}
@endif

