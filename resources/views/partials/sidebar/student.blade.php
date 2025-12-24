<ul class="menu">

    <li class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
        <a href="{{ route('student.dashboard') }}">
            <img src="{{ asset('images/home.png') }}" class="menu-icon">
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('student.kelas.index') ? 'active' : '' }}">
        <a href="{{ route('student.kelas.index') }}">
            <img src="{{ asset('images/school.png') }}" class="menu-icon">
            Kelas
        </a>
    </li>

    <li class="{{ request()->routeIs('student.materi.index') ? 'active' : '' }}">
        <a href="{{ route('student.materi.index') }}">
            <img src="{{ asset('images/book.png') }}" class="menu-icon">
            Materi
        </a>
    </li>

    <li class="{{ request()->routeIs('student.tugas.index') ? 'active' : '' }}">
        <a href="{{ route('student.tugas.index') }}">
            <img src="{{ asset('images/pen.png') }}" class="menu-icon">
            Tugas / Quiz
        </a>
    </li>

    <li class="{{ request()->routeIs('student.penilaian.index') ? 'active' : '' }}">
        <a href="{{ route('student.penilaian.index') }}">
            <img src="{{ asset('images/penilaian.png') }}" class="menu-icon">
            Penilaian
        </a>
    </li>

</ul>