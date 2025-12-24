<ul class="menu">

    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/home.png') }}" class="menu-icon">
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}">
            <img src="{{ asset('images/person.png') }}" class="menu-icon">
            Manajemen User
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.kelas.index') ? 'active' : '' }}">
        <a href="{{ route('admin.kelas.index') }}">
            <img src="{{ asset('images/school.png') }}" class="menu-icon">
            Manajemen Kelas
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.master.index') ? 'active' : '' }}">
        <a href="{{ route('admin.master.index') }}">
            <img src="{{ asset('images/datatransfer.png') }}" class="menu-icon">
            Master Data
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.monitoring.index') ? 'active' : '' }}">
        <a href="{{ route('admin.monitoring.index') }}">
            <img src="{{ asset('images/monitoring.png') }}" class="menu-icon">
            Pemantauan
        </a>
    </li>

</ul>
