<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'ApiForge'))</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.partials.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        @include('layouts.partials.navbar')

        <div class="body flex-grow-1 px-4">
            @yield('content')
        </div>
    </div>
@stack('scripts')
</body>
</html>