<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

use App\Http\Controllers\RaspberryPiStatsController;

Route::get('/stats-page', [RaspberryPiStatsController::class, 'index']);
