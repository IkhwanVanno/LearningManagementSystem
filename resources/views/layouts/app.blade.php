<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    @vite([
        'resources/css/layout.css',
        'resources/css/sidebar.css',
        'resources/css/main.css'
    ])
</head>

<body>

    <div class="app-container">

        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>

    </div>

</body>

</html>