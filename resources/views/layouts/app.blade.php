<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Word Games</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('navigation.css') }}"
    @livewireStyles
</head>
<body class="app-body">
    <x-navigation />
    <main class="main-container">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>