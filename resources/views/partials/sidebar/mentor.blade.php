<ul class="menu">

    <li class="{{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
        <a href="{{ route('mentor.dashboard') }}">
            <img src="{{ asset('images/home.png') }}" class="menu-icon">
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.kelas.index') ? 'active' : '' }}">
        <a href="{{ route('mentor.kelas.index') }}">
            <img src="{{ asset('images/school.png') }}" class="menu-icon">
            Manajemen Kelas
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.murid.index') ? 'active' : '' }}">
        <a href="{{ route('mentor.murid.index') }}">
            <img src="{{ asset('images/person.png') }}" class="menu-icon">
            Manajemen Murid
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.materi.index') ? 'active' : '' }}">
        <a href="{{ route('mentor.materi.index') }}">
            <img src="{{ asset('images/book.png') }}" class="menu-icon">
            Manajemen Materi
        </a>
    </li>

    <li class="{{ request()->routeIs('mentor.tugas.index') ? 'active' : '' }}">
        <a href="{{ route('mentor.tugas.index') }}">
            <img src="{{ asset('images/pen.png') }}" class="menu-icon">
            Tugas / Quiz</a>
    </li>

    <li class="{{ request()->routeIs('mentor.penilaian.index') ? 'active' : '' }}">
        <a href="{{ route('mentor.penilaian.index') }}">
            <img src="{{ asset('images/penilaian.png') }}" class="menu-icon">
            Penilaian
        </a>
    </li>

</ul>