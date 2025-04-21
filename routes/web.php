<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartenaireController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/Partenaire', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');
