<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    public function getNotifUser($user_id)
    {
        // $notifications = Notification::all()->where('is_read', false)->where('user_id', $user_id)->orderBy('createdAt', 'asc');
        $notifications = Notification::where('is_read', false)
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
        return $notifications;
    }

    public function totalNotification($user_id)
    {
        // $notifications = Notification::all()->where('is_read', false)->where('user_id', $user_id)->orderBy('createdAt', 'asc');
        $totalnotifications = Notification::all()->where('is_read', false)
        ->where('user_id', $user_id);

        return $totalnotifications->count();
    }

    public function create($type, $message, $user_id)
    {
        // 'user_id', 'type', 'message', 'is_read'
        // Validate input
        // $data = $request->validate([
        //     'type' => 'required|string|max:255',
        //     'message' => 'required|string',
        //     'user_id' => 'required|number',
        // ]);

        $data['is_read'] = false;

        // Create notification
        Notification::create($data);

        // Return plain string message
        return 'Notification created successfully.';
    }

    public function markAsRead($notId, $userId)
    {
        // Find the notification by ID
        $notification = Notification::where('id', $notId)->where('user_id', $userId)->first();

        // Check if the notification is read
        if ($notification->is_read) {
            return 'Notification is already read.';
        }

        // Mark the notification as read
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read.']);
    }
    public function delete($notId, $userId)
    {
        // Find the notification by ID
        $notification = Notification::where('id', $notId)->where('user_id', $userId)->first();

        // Check if the notification exists
        if (!$notification) {
            return 'Notification not found.';
        }

        // Delete the notification
        $notification->delete();

        return 'Notification deleted successfully.';
    }

    public function showAllNotifications(){
        $user = Auth::user();

        $notifications = Notification::where('user_id', operator: $user->id)->orderBy('created_at', 'desc')->get();
        return view('Partenaire.notifications', compact('notifications'));
    }

}