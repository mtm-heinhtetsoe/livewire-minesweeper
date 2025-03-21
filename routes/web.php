<?php

use App\Livewire\Minesweeper;
use App\Livewire\Wordoftheday;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/minesweeper', Minesweeper::class);
Route::get('/word-of-the-day', Wordoftheday::class);
