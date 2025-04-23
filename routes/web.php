<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\PartnerEquipmentController;
use App\Http\Controllers\Api\PartnerDashboardApiController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (placeholder for now)
Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

// Routes pour le tableau de bord partenaire
Route::get('/tableau-de-bord-partenaire', [PartnerDashboardController::class, 'index'])->name('partner.dashboard');

// Routes pour la gestion des équipements du partenaire
Route::get('/mes-equipements', [PartnerEquipmentController::class, 'index'])->name('partner.equipment');
Route::get('/mes-equipements/ajouter', [PartnerEquipmentController::class, 'create'])->name('partner.equipment.create');
Route::get('/mes-equipements/{id}/edit', [PartnerEquipmentController::class, 'edit'])->name('partner.equipment.edit');
Route::get('/mes-equipements/{id}/toggle-status', [PartnerEquipmentController::class, 'toggleStatus'])->name('partner.equipment.toggle-status');
Route::get('/mes-equipements/{id}/archive', [PartnerEquipmentController::class, 'archive'])->name('partner.equipment.archive');
Route::delete('/mes-equipements/{id}', [PartnerEquipmentController::class, 'destroy'])->name('partner.equipment.destroy');

// API routes
Route::get('/api/partner-dashboard', [PartnerDashboardApiController::class, 'index']);

// Listing routes
Route::get('/annonce/create', [ListingController::class, 'create'])->name('listing.create');
Route::post('/annonce/store', [ListingController::class, 'store'])->name('listing.store');
Route::get('/annonce/success', [ListingController::class, 'success'])->name('listing.success');

// Routes pour la gestion du profil utilisateur
Route::post('/partner/update-avatar', [UserProfileController::class, 'updatePartnerAvatar'])->name('partner.update-avatar');
