<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\ClientController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/Partenaire', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');
Route::post('/demandes/filter', [PartenaireController::class, 'filter'])->name('demandes.filter');
Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');
