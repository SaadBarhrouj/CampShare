<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');
