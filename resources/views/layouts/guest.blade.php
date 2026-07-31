<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ApiForge') }} @yield('title', 'Login')</title>

    {{--
        Prevents a flash of the wrong theme on load.
        CoreUI reads/writes this attribute for its color-mode (light/dark) switcher.
        Runs before CSS paints, so it must stay inline here rather than in app.js.
    --}}
    <script>
        (function () {
            const storedTheme = localStorage.getItem('coreui-theme') || 'auto';
            const theme = storedTheme === 'auto'
                ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
                : storedTheme;

            document.documentElement.setAttribute('data-coreui-theme', theme);
        })();
    </script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>