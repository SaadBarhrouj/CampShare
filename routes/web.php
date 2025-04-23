<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listings/all', [ListingController::class, 'indexAll'])->name('client.listings.indexAll');

Route::get('/listings/premium', [ListingController::class, 'indexPremium'])->name('client.listings.indexPremium');

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('client.listings.show');

Route::get('/listings', [ListingController::class, 'index'])->name('client.listings.index');


