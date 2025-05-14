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
use Illuminate\Routing\Controller;

class NotificationController extends Controller 
{

public static $clientNotificationTypes = [
        'review_object',
        'review_partner',
        'updated_listing',
        'added_listing',
        'accepted_reservation',
        'rejected_reservation',
        'reviewed'
    ];


    protected $partnerNotificationTypes = [
        'review_client',
        // 'new_reservation_request',
    ];



      public static function getUnreadClientNotificationCount(User $user = null): int
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return 0; 
        }


        return Notification::where('user_id', $user->id)
                           ->whereIn('type', self::$clientNotificationTypes)
                           ->where('is_read', false)
                           ->count();
    }


     public function getUnreadNotificationCountForHeader(User $user): int
    {
        $relevantTypes = []; 

        if ($user->role === 'partner') {
            $relevantTypes = $this->partnerNotificationTypes;
        } elseif ($user->role === 'client') {
            $relevantTypes = $this->clientNotificationTypes;
        }

        if (empty($relevantTypes)) {
            return 0;
        }

        return Notification::where('user_id', $user->id)
                           ->whereIn('type', $relevantTypes) 
                           ->where('is_read', false)         
                           ->count();
    }


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

    public function totalNotification($user_id)
    {
         if (Auth::id() != $user_id) {
            return 0;
        }
         return Notification::where('user_id', $user_id)
                           ->where('is_read', false)
                           ->count();
    }

    public function showClientNotifications()
    {
        $user = Auth::user();

        $clientNotificationTypes = [
            'review_object',
            'review_partner',
            'updated_listing',
            'added_listing',
            'accepted_reservation',
            'rejected_reservation',
            'reviewed'
        ];

        $notifications = Notification::where('user_id', $user->id)
                                    ->whereIn('type', $clientNotificationTypes)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10);

        return view('Client.notifications', compact('notifications', 'user'));
    }

    public function showPartnerNotifications()
    {
        $user = Auth::user();

        if ($user->role !== 'partner') {
             Log::warning("User {$user->id} (role: {$user->role}) attempted to access partner notifications page.");
             abort(403, 'Accès non autorisé à cette section.');
        }

        $partnerNotificationTypes = [
            'review_client',
        ];

        $notifications = Notification::where('user_id', $user->id)
                                    ->whereIn('type', $partnerNotificationTypes)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10);

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


      public function markAllClientVisibleAsRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }

        if (empty(self::$clientNotificationTypes)) {
            Log::error("Le tableau clientNotificationTypes est vide dans NotificationController.");
            return response()->json(['message' => 'Erreur de configuration interne du serveur.'], 500);
        }

        $updatedCount = Notification::where('user_id', $user->id)
            ->whereIn('type', self::$clientNotificationTypes)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        Log::info("{$updatedCount} notifications CLIENT marquées comme lues pour l'utilisateur ID {$user->id}.");
        return response()->json([
            'message' => "{$updatedCount} notifications client marquée(s) comme lue(s).",
            'updated_count' => $updatedCount
        ]);
    }


    public function deleteNotification(Notification $notification, User $user)
    {
         if ($notification->user_id !== Auth::id() || $user->id !== Auth::id()) {
             Log::warning('Unauthorized attempt to delete notification.', [
                 'auth_user_id' => Auth::id(), 'notification_id' => $notification->id, 'target_user_id' => $user->id
             ]);
             return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $notificationId = $notification->id;
        $notification->delete();
        Log::info("Notification ID {$notificationId} deleted for User ID {$user->id}");

        return response()->noContent();
    }

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
        return response()->noContent();
    }


     public function markAllPartnerVisibleAsRead(Request $request) // Nom de méthode cohérent
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'partner') { // S'assurer que l'utilisateur est un partenaire
            return response()->json(['message' => 'Non autorisé ou non authentifié.'], 403);
        }

        if (empty($this->partnerNotificationTypes)) {
            Log::error("La liste partnerNotificationTypes est vide dans NotificationController pour markAllPartnerVisibleAsRead.");
            return response()->json(['message' => 'Erreur de configuration interne.'], 500);
        }

        $updatedCount = Notification::where('user_id', $user->id)
            ->whereIn('type', $this->partnerNotificationTypes) // Filtre par types partenaire
            ->where('is_read', false)
            ->update(['is_read' => true]);

        Log::info("{$updatedCount} notifications PARTENAIRE marquées comme lues pour l'utilisateur ID {$user->id}.");
        return response()->json([
            'message' => "{$updatedCount} notifications partenaire marquées comme lues.",
            'updated_count' => $updatedCount
        ]);
    }

    /**
     * Supprime les notifications CLIENT sélectionnées.
     */
    public function deleteSelectedClientNotifications(Request $request) // Nom de méthode cohérent
    {
        $user = Auth::user();
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notifications,id', // Valide que les IDs existent dans la table notifications
        ]);

        if (!$user) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }
        // Optionnel: vérifier le rôle client
        // if ($user->role !== 'client') { ... }

        // S'assurer que l'utilisateur ne supprime que SES propres notifications
        // et uniquement celles du type CLIENT pour plus de sécurité.
        $deletedCount = Notification::where('user_id', $user->id)
            ->whereIn('id', $validated['ids'])
            ->whereIn('type', self::$clientNotificationTypes) // Sécurité: ne supprime que les types client
            ->delete();

        Log::info("{$deletedCount} notifications CLIENT supprimées pour l'utilisateur ID {$user->id}. IDs: " . implode(',', $validated['ids']));
        return response()->json(['message' => "{$deletedCount} notifications client sélectionnées ont été supprimées.", 'deleted_count' => $deletedCount]);
    }

    /**
     * Supprime les notifications PARTENAIRE sélectionnées.
     */
    public function deleteSelectedPartnerNotifications(Request $request) // Nom de méthode cohérent
    {
        $user = Auth::user();
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notifications,id',
        ]);

        if (!$user || $user->role !== 'partner') {
            return response()->json(['message' => 'Non autorisé ou non authentifié.'], 403);
        }

        if (empty($this->partnerNotificationTypes)) {
            Log::error("La liste partnerNotificationTypes est vide dans NotificationController pour deleteSelectedPartnerNotifications.");
            return response()->json(['message' => 'Erreur de configuration interne.'], 500);
        }
        
        $deletedCount = Notification::where('user_id', $user->id)
            ->whereIn('id', $validated['ids'])
            ->whereIn('type', $this->partnerNotificationTypes) // Sécurité: ne supprime que les types partenaire
            ->delete();

        Log::info("{$deletedCount} notifications PARTENAIRE supprimées pour l'utilisateur ID {$user->id}. IDs: " . implode(',', $validated['ids']));
        return response()->json(['message' => "{$deletedCount} notifications partenaire sélectionnées ont été supprimées.", 'deleted_count' => $deletedCount]);
    }
}