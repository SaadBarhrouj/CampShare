<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;      // Nécessaire pour View::composer
use Illuminate\Support\Facades\Auth;      // Nécessaire pour Auth::check() et Auth::user()
use App\Http\Controllers\NotificationController; // Chemin vers votre NotificationController

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuration de la localisation pour Carbon et l'application
        Carbon::setLocale('fr');
        App::setLocale('fr'); // Laravel 9+
        // Pour Laravel < 9, c'était souvent config(['app.locale' => 'fr']); ou via un middleware.
        // App::setLocale('fr') est la méthode moderne et préférée.

        // Partager le nombre de notifications CLIENT non lues avec toutes les vues
        // Ce View Composer sera exécuté chaque fois qu'une vue est sur le point d'être rendue.
        View::composer('*', function ($view) {
            $unreadClientNotificationsCountGlobal = 0; // Valeur par défaut

            // Vérifier si un utilisateur est authentifié
            if (Auth::check()) {
                // Récupérer l'utilisateur authentifié
                $user = Auth::user();
                // Appeler la méthode statique de NotificationController pour obtenir le nombre
                // de notifications client non lues pour cet utilisateur.
                $unreadClientNotificationsCountGlobal = NotificationController::getUnreadClientNotificationCount($user);
            }

            // Rendre la variable $unreadClientNotificationsCountGlobal disponible dans la vue actuelle.
            // Vous pourrez y accéder dans vos fichiers Blade avec {{ $unreadClientNotificationsCountGlobal }}.
            $view->with('unreadClientNotificationsCountGlobal', $unreadClientNotificationsCountGlobal);
        });
    }
}