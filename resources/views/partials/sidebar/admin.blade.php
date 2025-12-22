<ul class="menu">

    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/home.png') }}" class="menu-icon">
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <a href="{{ route('admin.users') }}">
            <img src="{{ asset('images/person.png') }}" class="menu-icon">
            Manajemen User
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.kelas') ? 'active' : '' }}">
        <a href="{{ route('admin.kelas') }}">
            <img src="{{ asset('images/school.png') }}" class="menu-icon">
            Manajemen Kelas
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.master') ? 'active' : '' }}">
        <a href="{{ route('admin.master') }}">
            <img src="{{ asset('images/datatransfer.png') }}" class="menu-icon">
            Master Data
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.monitoring') ? 'active' : '' }}">
        <a href="{{ route('admin.monitoring') }}">
            <img src="{{ asset('images/monitoring.png') }}" class="menu-icon">
            Pemantauan
        </a>
    </li>

</ul>
