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
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\ReviewAdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminDetailsEquipmentController;



// Routes publiques //

// Index Page
Route::get('/', function () {
    return view('index');
})->name('index');



// Accessibles à tous //

// Listings Client Routes
Route::get('/listings/all', [ListingController::class, 'indexAll'])->name('client.listings.indexAll');
Route::get('/listings/premium', [ListingController::class, 'indexPremium'])->name('client.listings.indexPremium');
Route::get('/listings', [ListingController::class, 'index'])->name('client.listings.index');
Route::get('/listings/{listing}', [EquipmentDetailController::class, 'show'])->name('client.listings.show');



// Legal Routes
Route::get('/conditions-generales-partenaires', function () {
    return view('legal.conditions-generales-partenaires');
})->name('conditions.generales');





// Partner Routes
Route::get('/Partenaire/MesEquipement', [PartenaireController::class, 'ShowMesEquipement'])->name('MesEquipement');
Route::get('/Partenaire/Mesannonces', [PartenaireController::class, 'ShowMesAnnonces'])->name('HomePartenaie.mesannonces');
Route::get('/Partenaire/DemandeLocation', [PartenaireController::class, 'ShowDemandeLocation'])->name('HomePartenaie.demandes');
Route::get('/Partenaire/LocationEnCours', [PartenaireController::class, 'ShowLocationEnCours'])->name('HomePartenaie.locations.en.cours');
Route::get('/Partenaire/AvisRecus', [PartenaireController::class, 'ShowAvisRecus'])->name('HomePartenaie.avis');
Route::get('/Partenaire/Dashboard', [PartenaireController::class, 'ShowHomePartenaire'])->name('HomePartenaie');




// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



// Registration Routes
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/devenir_partenaire', [PartenaireController::class, 'devenir_partenaire'])->name('devenir_partenaire');


// Profile Routes
Route::get('/profile/client/{user}', [ProfileController::class, 'indexClientProfile'])->name('client.profile.index');
Route::get('/profile/partner/{user}', [ProfileController::class, 'indexPartnerProfile'])->name('partner.profile.index');





// Routes protégées par authentification
Route::middleware(['auth', 'active.account'])->group(function () {

    // Routes Communes
    Route::get('/equipment/{listing}/reserved-dates', [EquipmentDetailController::class, 'getReservedDates'])->name('equipment.reserved-dates');
    Route::post('/user/become-partner', [UserController::class, 'becomePartner'])->name('user.become-partner');

    
    // Routes Client
    Route::middleware(['client'])->group(function () {

        Route::get('/client/reservations/filter', [ClientController::class, 'ShowHomeClient'])->name('profile');
        Route::post('/profile', [ClientController::class, 'update'])->name('profile.update');
        Route::get('/MesReservation', [ClientController::class, 'ShowMesReservationClient'])->name('HomeClient.reservations');
        Route::get('/AvisRecus', [ClientController::class, 'ShowAvisRecusClient'])->name('HomeClient');
        Route::get('/EquipementRecommende', [ClientController::class, 'ShowEquipementRecommendeClient'])->name('HomeClient.equips');
        Route::get('/Client/profile', [ClientController::class, 'ShowProfileClient'])->name('HomeClient.profile');
        Route::get('/Client', [ClientController::class, 'ShowHomeClient'])->name('HomeClient');


        Route::post('/client/reservations/cancel/{id}', [ClientController::class, 'cancel'])->name('client.reservations.cancel');

        Route::get('/devenir_partenaire_page', [PartenaireController::class, 'ShowDevenirPartenaireForm'])->name('DevenirPartenairePage');
        Route::post('/devenir_partenaire', [PartenaireController::class, 'devenir_partenaire'])->name('devenir_partenaire');

        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

        Route::get('/client/notifications', [NotificationController::class, 'showClientNotifications'])
        ->name('notifications.client.index');



    });

    Route::middleware(['partner'])->group(function () {


        // Équipement routes
        Route::get('/partenaire/equipements', [PartenaireController::class, 'showEquipements'])->name('partenaire.equipements');
        Route::post('/partenaire/equipements/create', [PartenaireController::class, 'createEquipement'])->name('partenaire.equipements.create');
        Route::put('/partenaire/equipements/{item}', [PartenaireController::class, 'updateEquipement'])->name('partenaire.equipements.update');
        Route::delete('/partenaire/equipements/{item}', [PartenaireController::class, 'deleteEquipement'])->name('partenaire.equipements.delete');
        Route::get('/partenaire/equipements/{item}/reviews', [PartenaireController::class, 'getEquipementReviews'])->name('partenaire.equipements.reviews');
        Route::get('/partenaire/equipements/{item}/details', [PartenaireController::class, 'getEquipementDetails'])->name('partenaire.equipements.details');

        Route::delete('/partenaire/equipements/delete-all', [PartenaireController::class, 'deleteAllEquipements'])->name('partenaire.equipements.delete-all');
        Route::get('/profile_partenaire', [PartenaireController::class, 'voir_profile_partenaire'])->name('partenaire.profile');

        Route::post('/demandes/filter', [PartenaireController::class, 'filter'])->name('demandes.filter');
        Route::post('/demandes/EnCours', [PartenaireController::class, 'filterLocationEnCours'])->name('demandes.filter.Encours');
        Route::post('/Avis/filter', [PartenaireController::class, 'Avisfilter'])->name('Avis.filter');


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

        // Notifications
        Route::get('/partenaire/notifications', [NotificationController::class, 'showPartnerNotifications'])->name('notifications.partner.index'); 

        
        //Mail Routes
        Route::post('/partenaire/reservations/{reservation}/accept', [ReservationController::class, 'accept'])->name('partenaire.reservations.accept');
        Route::post('/partenaire/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('partenaire.reservations.reject');


        Route::get('/partenaire/notifications', [NotificationController::class, 'showPartnerNotifications'])->name('notifications.partner.index'); 
    }); 


    Route::middleware(['admin'])->group(function () {


        Route::prefix('admin')->group(function () {
            
            Route::get('/equipments/{listing}', [AdminDetailsEquipmentController::class, 'show'])->name('admin.equipments.show');
            Route::get('/admin/reviews', [ReviewAdminController::class, 'index'])->name('admin.reviews');
            Route::get('/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
            Route::get('/equipements', [EquipementController::class, 'index'])->name('equipements.index'); 
            Route::get('/equipments', [AdminController::class, 'equipments'])->name('admin.equipments');   
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
            Route::get('/partners', [AdminController::class, 'partners'])->name('admin.partners');
            Route::get('/users/{user}/details', [AdminController::class, 'getUserDetails'])->name('admin.user.details');
            Route::post('/users/{user}/update', [AdminController::class, 'updateUserDetails'])->name('admin.user.update');
            Route::post('/users/{user}/deactivate', [UserController::class, 'deactivateUser'])->name('admin.users.deactivate');
            Route::post('/users/{id}/toggle-activation', [UserController::class, 'toggleActivation'])->name('admin.users.toggleActivation');

        });

        // Routes pour le nettoyage et la maintenance
        Route::get('/cleanup/all-equipments', [CleanupController::class, 'cleanAllEquipments'])->name('cleanup.all-equipments');
        Route::get('/cleanup/fix-images', [CleanupController::class, 'fixImageStorage'])->name('cleanup.fix-images');
        Route::get('/fix-equipment-images', [ImageFixController::class, 'fixImages'])->name('fix.equipment.images');
        Route::get('/fix-images', [ImageFixController::class, 'fixImages'])->name('fix.images');



        Route::get('/admin/recent-reservations', [AdminController::class, 'getRecentReservations']);
        Route::get('/admin/recent-equipments', [AdminController::class, 'getRecentEquipments']);
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');



    });



    // Notification Routes
    Route::get('/showAllNotifications', [NotificationController::class, 'showAllNotifications'])->name('showAllNotifications');

    Route::post('/notifications/{notification}/mark-read/{user}', [NotificationController::class, 'markNotificationAsRead'])
        ->name('notifications.markAsRead.ajax')
        ->where(['notification' => '[0-9]+', 'user' => '[0-9]+']);
        
    Route::delete('/notifications/{notification}/delete/{user}', [NotificationController::class, 'deleteNotification'])
        ->name('notifications.delete.ajax') // Nom différent
        ->where(['notification' => '[0-9]+', 'user' => '[0-9]+']);


    // Routes pour les Avis 
    Route::get('/reservations/{reservation}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');






});