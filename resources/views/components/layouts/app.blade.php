<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('minesweeper.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('navigation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('wordoftheday.css') }}">


        <title>{{ $title ?? 'Minesweeper' }}</title>
    </head>
    <body>
        <nav class="nav-container">
            <div class="nav-content">
                <div class="nav-brand">Word Games</div>
                <div class="nav-links">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/word-of-the-day" class="nav-link">Word of the Day</a>
                    <a href="/minesweeper" class="nav-link">Minesweeper</a>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </body>
</html>
