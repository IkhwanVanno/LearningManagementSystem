<aside class="sidebar">

    <div class="sidebar-header">
        <div class="avatar"></div>

        <div class="role-wrapper">
            <img src="{{ asset('images/profile.png') }}" class="role-icon">
            <h3>{{ strtoupper(auth()->user()->name) }}</h3>
        </div>
    </div>

    @if(auth()->user()->role->name === 'admin')
        @include('partials.sidebar.admin')
    @elseif(auth()->user()->role->name === 'mentor')
        @include('partials.sidebar.mentor')
    @else
        @include('partials.sidebar.student')
    @endif

    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-btn">
            <img src="{{ asset('images/logout.png') }}" class="logout-icon">
            Keluar
        </button>
    </form>


</aside>