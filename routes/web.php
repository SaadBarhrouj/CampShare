<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
});