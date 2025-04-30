<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\AuthController;


// Index Page
Route::get('/', function () {
    return view('index');
});

// Listings Client Routes
Route::get('/listings/all', [ListingController::class, 'indexAll'])->name('client.listings.indexAll');
Route::get('/listings/premium', [ListingController::class, 'indexPremium'])->name('client.listings.indexPremium');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('client.listings.show');
Route::get('/listings', [ListingController::class, 'index'])->name('client.listings.index');



// Partner Routes
Route::get('/Partenaire', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');
Route::post('/reservation/action', [PartenaireController::class, 'handleAction'])->name('reservation.action');
Route::post('/demandes/filter', [PartenaireController::class, 'filter'])->name('demandes.filter');
Route::post('/demandes/EnCours', [PartenaireController::class, 'filterLocationEnCours'])->name('demandes.filter.Encours');
Route::post('/Avis/filter', [PartenaireController::class, 'Avisfilter'])->name('Avis.filter');





// Client Routes
//Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');
Route::get('/client/reservations/filter', [ClientController::class, 'ShowHomeClient'])->name('profile');
Route::post('/profile', [ClientController::class, 'update'])->name('profile.update');
Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');
Route::post('/client/reservations/cancel/{id}', [ClientController::class, 'cancel'])->name('client.reservations.cancel');



// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
    Route::get('/partners', [AdminController::class, 'partners'])->name('admin.partners'); });



// Registration Routes
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

