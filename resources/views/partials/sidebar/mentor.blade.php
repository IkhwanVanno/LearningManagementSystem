<ul class="menu">

    <li class="{{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
        <a href="{{ route('mentor.dashboard') }}">
            <img src="{{ asset('images/home.png') }}" class="menu-icon">
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.kelas') ? 'active' : '' }}">
        <a href="{{ route('mentor.kelas') }}">
            <img src="{{ asset('images/school.png') }}" class="menu-icon">
            Manajemen Kelas
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.murid') ? 'active' : '' }}">
        <a href="{{ route('mentor.murid') }}">
            <img src="{{ asset('images/person.png') }}" class="menu-icon">
            Manajemen Murid
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.materi') ? 'active' : '' }}">
        <a href="{{ route('mentor.materi') }}">
            <img src="{{ asset('images/book.png') }}" class="menu-icon">
            Manajemen Materi
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.tugas') ? 'active' : '' }}">
        <a href="{{ route('mentor.tugas') }}">
            <img src="{{ asset('images/pen.png') }}" class="menu-icon">
            Tugas / Quiz</a>
    </li>

    <li class="{{ request()->routeIs('mentor.penilaian') ? 'active' : '' }}">
        <a href="{{ route('mentor.penilaian') }}">
            <img src="{{ asset('images/penilaian.png') }}" class="menu-icon">
            Penilaian
        </a>
    </li>

</ul>