<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CleanupController;
use App\Http\Controllers\ImageFixController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ListingController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipmentDetailController;


// Index Page
Route::get('/', function () {
    return view('index');
})->name('index');

// Listings Client Routes
Route::get('/listings/all', [ListingController::class, 'indexAll'])->name('client.listings.indexAll');
Route::get('/listings/premium', [ListingController::class, 'indexPremium'])->name('client.listings.indexPremium');
Route::get('/listings', [ListingController::class, 'index'])->name('client.listings.index');



// Partner Routes
Route::get('/Partenaire', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');
Route::post('/reservation/action', [PartenaireController::class, 'handleAction'])->name('reservation.action');
Route::post('/demandes/filter', [PartenaireController::class, 'filter'])->name('demandes.filter');
Route::post('/demandes/EnCours', [PartenaireController::class, 'filterLocationEnCours'])->name('demandes.filter.Encours');
Route::post('/Avis/filter', [PartenaireController::class, 'Avisfilter'])->name('Avis.filter');


// Équipement routes
Route::get('/partenaire/equipements', [PartenaireController::class, 'showEquipements'])->name('partenaire.equipements');
Route::post('/partenaire/equipements/create', [PartenaireController::class, 'createEquipement'])->name('partenaire.equipements.create');
Route::put('/partenaire/equipements/{item}', [PartenaireController::class, 'updateEquipement'])->name('partenaire.equipements.update');
Route::delete('/partenaire/equipements/{item}', [PartenaireController::class, 'deleteEquipement'])->name('partenaire.equipements.delete');
Route::get('/partenaire/equipements/{item}/reviews', [PartenaireController::class, 'getEquipementReviews'])->name('partenaire.equipements.reviews');
Route::delete('/partenaire/equipements/delete-all', [PartenaireController::class, 'deleteAllEquipements'])->name('partenaire.equipements.delete-all');

// Annonce routes
Route::get('/partenaire/annonces/create/{equipment_id}', [PartenaireController::class, 'createAnnonceForm'])->name('partenaire.annonces.create');
Route::post('/partenaire/annonces/store', [PartenaireController::class, 'storeAnnonce'])->name('partenaire.annonces.store');
Route::get('/partenaire/mes-annonces', [PartenaireController::class, 'mesAnnonces'])->name('partenaire.mes-annonces');
Route::get('/partenaire/annonces/{listing}/edit', [PartenaireController::class, 'editAnnonce'])->name('partenaire.annonces.edit');
Route::put('/partenaire/annonces/{listing}/update', [PartenaireController::class, 'updateAnnonce'])->name('partenaire.annonces.update');
Route::put('/partenaire/annonces/{listing}/archive', [PartenaireController::class, 'archiveAnnonce'])->name('partenaire.annonces.archive');
Route::delete('/partenaire/annonces/{listing}/delete', [PartenaireController::class, 'deleteAnnonce'])->name('partenaire.annonces.delete');

// Routes pour le nettoyage et la maintenance
Route::prefix('cleanup')->group(function () {
    Route::get('/all-equipments', [CleanupController::class, 'cleanAllEquipments'])->name('cleanup.all-equipments');
    Route::get('/fix-images', [CleanupController::class, 'fixImageStorage'])->name('cleanup.fix-images');
});

// Route pour le diagnostic et la correction des images
Route::get('/fix-equipment-images', [ImageFixController::class, 'fixImages'])->name('fix.equipment.images');

// Route temporaire pour la correction des images
Route::get('/fix-images', [App\Http\Controllers\ImageFixController::class, 'fixImages'])->name('fix.images');

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
////////////////////////////////////////////////
Route::get('/showAllNotifications', [NotificationController::class, 'showAllNotifications'])->name('showAllNotifications');

// Profiles Routes
Route::get('/profile/client/{user}', [ProfileController::class, 'indexClientProfile'])->name('client.profile.index');
Route::get('/profile/partner/{user}', [ProfileController::class, 'indexPartnerProfile'])->name('partner.profile.index');



Route::get('/equipment/{listing}/reserved-dates', [EquipmentDetailController::class, 'getReservedDates'])->name('equipment.reserved-dates');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/listings/{listing}', [EquipmentDetailController::class, 'show'])->name('client.listings.show');
