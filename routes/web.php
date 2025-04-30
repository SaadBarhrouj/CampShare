<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])
    ->name('profile.update-avatar')
    ->middleware('auth');

    Route::post('/user/become-partner', [UserController::class, 'becomePartner'])->middleware('auth')->name('user.become-partner');

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
    Route::get('/admin/users/{user}/details', [AdminController::class, 'getUserDetails'])
    ->name('admin.user.details');
    Route::post('/admin/users/{user}/update', [AdminController::class, 'updateUserDetails'])
    ->name('admin.user.update');

Route::get('/download-contract', [AuthController::class, 'downloadContract'])
    ->name('contract.download')
    ->middleware('auth');
    
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::post('/users/{user}/deactivate', [UserController::class, 'deactivateUser'])
            ->name('admin.users.deactivate');
    });
    
    Route::post('/admin/users/{id}/toggle-activation', [UserController::class, 'toggleActivation'])
    ->name('admin.users.toggleActivation');

    
    // Registration Routes
    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
    
    // Login Routes
    Route::middleware(['auth'])->get('/download-contract', [ContractController::class, 'downloadContract'])->name('download.contract');
    

    // Routes web.php
      Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Routes for Admin
    //Route::get('/admin', function () {
    //    return view('admin'); 
    //})->name('admin.dashboard');
    
    // Routes for Partenaire (Proprietaire)
    
    Route::get('/partenaire', function () {
        return view('partenaire');
    })->name('partenaire.dashboard');

    Route::post('/reservation/action', [PartenaireController::class, 'handleAction'])->name('reservation.action');

    
    use App\Http\Controllers\AgreementController;
    
    Route::get('/agreement/pdf', [AgreementController::class, 'generateAgreement'])->name('agreement.pdf');
    
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    // Annonces Route
    Route::get('/auth/annonces', function () {
        return view('auth.annonces');
    })->middleware('auth')->name('annonces');
    
    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('auth')->name('dashboard');
    
