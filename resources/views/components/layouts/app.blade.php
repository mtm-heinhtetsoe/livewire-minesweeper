<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('minesweeper.css') }}">

        <title>{{ $title ?? 'Minesweeper' }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
