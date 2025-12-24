<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite([
        // CSS Files
        'resources/css/layout.css',
        'resources/css/sidebar.css',
        'resources/css/profile.css',
        'resources/css/main.css',
        'resources/css/toast.css',

        // JS Libraries
        'resources/js/toast.js',
    ])

    @stack('styles')
</head>

<body>
    <div class="app-container">
        <x-sidebar />

        <main class="main-container">
            @yield('content')
        </main>
    </div>

    <x-toast />
    @stack('scripts')
</body>

</html>