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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController; 

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
Route::get('/partenaire/equipements/{item}/details', [PartenaireController::class, 'getEquipementDetails'])->name('partenaire.equipements.details');

Route::delete('/partenaire/equipements/delete-all', [PartenaireController::class, 'deleteAllEquipements'])->name('partenaire.equipements.delete-all');
Route::get('/profile_partenaire', [PartenaireController::class, 'voir_profile_partenaire'])->name('partenaire.profile');

Route::get('/devenir_partenaire', [PartenaireController::class, 'devenir_partenaire'])->name('devenir_partenaire');



// Annonce routes
Route::get('/partenaire/annonces/create/{equipment_id}', [PartenaireController::class, 'createAnnonceForm'])->name('partenaire.annonces.create');
Route::post('/partenaire/annonces/store', [PartenaireController::class, 'storeAnnonce'])->name('partenaire.annonces.store');
Route::get('/partenaire/mes-annonces', [PartenaireController::class, 'mesAnnonces'])->name('partenaire.mes-annonces');
Route::get('/partenaire/annonces/{listing}/details', [PartenaireController::class, 'showAnnonceDetails'])->name('partenaire.annonces.details');

Route::get('/partenaire/annonces/{listing}/edit', [PartenaireController::class, 'editAnnonce'])->name('partenaire.annonces.edit');
Route::put('/partenaire/annonces/{listing}/update', [PartenaireController::class, 'updateAnnonce'])->name('partenaire.annonces.update');
Route::put('/partenaire/annonces/{listing}/archive', [PartenaireController::class, 'archiveAnnonce'])->name('partenaire.annonces.archive');
Route::delete('/partenaire/annonces/{listing}/delete', [PartenaireController::class, 'deleteAnnonce'])->name('partenaire.annonces.delete');
Route::post('/reservation/action', [PartenaireController::class, 'handleAction'])->name('reservation.action');


//////////


////////////////


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
Route::get('/client/reservations/filter', [ClientController::class, 'ShowHomeClient'])->name('profile');
Route::post('/profile', [ClientController::class, 'update'])->name('profile.update');
Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');
Route::post('/client/reservations/cancel/{id}', [ClientController::class, 'cancel'])->name('client.reservations.cancel');


// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
    Route::get('/partners', [AdminController::class, 'partners'])->name('admin.partners');
    Route::get('/users/{user}/details', [AdminController::class, 'getUserDetails'])->name('admin.user.details');
    Route::post('/users/{user}/update', [AdminController::class, 'updateUserDetails'])->name('admin.user.update');
    Route::post('/users/{user}/deactivate', [UserController::class, 'deactivateUser'])
        ->name('admin.users.deactivate')
        ->middleware(['auth', 'admin']);
    Route::post('/users/{id}/toggle-activation', [UserController::class, 'toggleActivation'])
        ->name('admin.users.toggleActivation');
});


Route::get('/admin/recent-reservations', [AdminController::class, 'getRecentReservations']);
Route::get('/admin/recent-equipments', [AdminController::class, 'getRecentEquipments']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/users/{user}/save-notes', [UserController::class, 'saveNotes']);



// Registration Routes
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);


// Reservation Routes
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/reservation/action', [PartenaireController::class, 'handleAction'])->name('reservation.action');
Route::post('/client/reservations/cancel/{id}', [ClientController::class, 'cancel'])->name('client.reservations.cancel');


// Listings Client Routes
Route::get('/listings/{listing}', [EquipmentDetailController::class, 'show'])->name('client.listings.show');
Route::get('/equipment/{listing}/reserved-dates', [EquipmentDetailController::class, 'getReservedDates'])->name('equipment.reserved-dates');



// Image Fix Routes
Route::get('/fix-equipment-images', [ImageFixController::class, 'fixImages'])->name('fix.equipment.images');
Route::get('/fix-images', [ImageFixController::class, 'fixImages'])->name('fix.images');


// Profile Routes
Route::get('/profile/client/{user}', [ProfileController::class, 'indexClientProfile'])->name('client.profile.index');
Route::get('/profile/partner/{user}', [ProfileController::class, 'indexPartnerProfile'])->name('partner.profile.index');



// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Notification Routes
Route::get('/showAllNotifications', [NotificationController::class, 'showAllNotifications'])->name('showAllNotifications');


// User Routes
Route::post('/user/become-partner', [UserController::class, 'becomePartner'])
    ->middleware('auth')
    ->name('user.become-partner');


//Mail Routes
Route::post('/partenaire/reservations/{reservation}/accept', [ReservationController::class, 'accept'])
    ->middleware(['auth']) // Ou ['auth', 'role:partner'] 
    ->name('partenaire.reservations.accept');

    Route::post('/partenaire/reservations/{reservation}/reject', [ReservationController::class, 'reject'])
    ->name('partenaire.reservations.reject');


     // Notification Routes

     Route::middleware('auth')->group(function () {
    
        Route::get('/notifications', [NotificationController::class, 'showAllNotifications'])->name('notifications.index'); // Nom ajouté pour cohérence
    
        Route::post('/notifications/{notification}/mark-read/{user}', [NotificationController::class, 'markNotificationAsRead'])
             ->name('notifications.markAsRead.ajax')
             ->where(['notification' => '[0-9]+', 'user' => '[0-9]+']);
    
        Route::delete('/notifications/{notification}/delete/{user}', [NotificationController::class, 'deleteNotification'])
             ->name('notifications.delete.ajax') // Nom différent
             ->where(['notification' => '[0-9]+', 'user' => '[0-9]+']);
    
         // Route::post('/notifications/{notId}/mark-read/{userId}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead.old');
         // Route::delete('/notifications/{notId}/delete/{userId}', [NotificationController::class, 'delete'])->name('notifications.delete.old');
    
    
         // Routes pour les Avis 
         Route::get('/reservations/{reservation}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
         Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
        // ...
    });

        // Legal Routes
        Route::get('/conditions-generales-partenaires', function () {
            return view('legal.conditions-generales-partenaires');
        })->name('conditions.generales');