<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// Importe la classe Controller de base
use Illuminate\Routing\Controller; 

class NotificationController extends Controller 
{


    /**
     * Récupère les 5 dernières notifications non lues pour l'utilisateur spécifié.
     * Utilisé pour l'aperçu dans le header.
     */
    public function getNotifUser($user_id)
    {
        if (Auth::id() != $user_id) {
            return collect(); 
        }

        return Notification::where('user_id', $user_id)
                            ->where('is_read', false)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
    }

    /**
     * Compte le nombre total de notifications non lues pour l'utilisateur spécifié.
     * Utilisé pour le badge numérique.
     */
    public function totalNotification($user_id)
    {
         if (Auth::id() != $user_id) {
            return 0;
        }
         return Notification::where('user_id', $user_id)
                           ->where('is_read', false)
                           ->count();
    }

    /**
     * Affiche toutes les notifications de l'utilisateur authentifié, avec pagination.
     * Utilisé pour la page principale des notifications.
     */
    public function showAllNotifications(){
        $user = Auth::user(); 
        $notifications = Notification::where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(4); 

        return view('Partenaire.notifications', compact('notifications', 'user'));
    }

    public function markNotificationAsRead(Notification $notification, User $user)
    {
        if ($notification->user_id !== Auth::id() || $user->id !== Auth::id()) {
             Log::warning('Unauthorized attempt to mark notification as read.', [
                 'auth_user_id' => Auth::id(), 'notification_id' => $notification->id, 'target_user_id' => $user->id
             ]);
             return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        if ($notification->is_read) {
            return response()->json(['message' => 'Notification déjà marquée comme lue.'], 200);
        }

        $notification->update(['is_read' => true]);
        Log::info("Notification ID {$notification->id} marked as read for User ID {$user->id}");
        return response()->json(['message' => 'Notification marquée comme lue.']);
    }


    public function deleteNotification(Notification $notification, User $user)
    {
         if ($notification->user_id !== Auth::id() || $user->id !== Auth::id()) {
             Log::warning('Unauthorized attempt to delete notification.', [
                 'auth_user_id' => Auth::id(), 'notification_id' => $notification->id, 'target_user_id' => $user->id
             ]);
             return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $notificationId = $notification->id; // Garder l'ID pour le log
        $notification->delete();
        Log::info("Notification ID {$notificationId} deleted for User ID {$user->id}");

        return response()->noContent();
    }


    /**
     * Marque comme lu (via IDs). Vérifie l'authentification.
     */
    public function markAsRead($notId, $userId)
    {
         if (Auth::id() != $userId) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }
        $notification = Notification::where('id', $notId)->where('user_id', $userId)->first();
        if (!$notification) {
             return response()->json(['message' => 'Notification non trouvée.'], 404);
        }
        if ($notification->is_read) {
             return response()->json(['message' => 'Notification déjà marquée comme lue.'], 200);
        }
        $notification->update(['is_read' => true]);
        return response()->json(['message' => 'Notification marquée comme lue.']);
    }

    /**
     *  Supprime (via IDs). Vérifie l'authentification.
     */
    public function delete($notId, $userId)
    {
        if (Auth::id() != $userId) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }
        $notification = Notification::where('id', $notId)->where('user_id', $userId)->first();
        if (!$notification) {
             return response()->json(['message' => 'Notification non trouvée.'], 404);
        }
        $notificationId = $notification->id;
        $notification->delete();
        Log::info("(Original Method) Notification ID {$notificationId} deleted for User ID {$userId}");
        return response()->noContent(); // 204
    }

    // ---a faire .... ---
    /*
    public function markAllAsRead(Request $request) { ... }
    public function deleteSelected(Request $request) { ... }
    */
}