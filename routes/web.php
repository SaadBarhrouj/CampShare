<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listings/all', [ListingController::class, 'indexAll'])->name('client.listings.indexAll');

Route::get('/listings/premium', [ListingController::class, 'indexPremium'])->name('client.listings.indexPremium');

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('client.listings.show');

Route::get('/listings', [ListingController::class, 'index'])->name('client.listings.index');

Route::get('/Partenaire', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');
Route::post('/demandes/filter', [PartenaireController::class, 'filter'])->name('demandes.filter');
Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
    Route::get('/partners', [AdminController::class, 'partners'])->name('admin.partners'); });

