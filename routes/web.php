<?php

use App\Livewire\Minesweeper;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/minesweeper', Minesweeper::class);
