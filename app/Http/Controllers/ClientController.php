<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Availability; 
use App\Models\Category;
use App\Models\City;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ClientModel;
use Illuminate\Support\Facades\File;
use App\Models\PartenaireModel;



use App\Models\Review;
use App\Models\User;


class ClientController extends Controller
{
    function ShowHomeClient () {
        $cities = PartenaireModel::getCities();
        $user = Auth::user();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);
       
        if(request()->ajax() && request()->has('status')) {
            $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email, request('status'));
            return view('Client.partials.reservations-grid', compact('allReservations'));
        }
        
        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getReviewsAboutMe($user->email);
        $profile = ClientModel::getClientProfile($user->email); 

        $liss = Listing::latest()->where('status', 'active')->take(3)->get();

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);
        return view('Client.tablea_de_bord_client',compact('liss', 'totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification','cities'));
        
    }
    function ShowMesReservationClient () {
        $user = Auth::user();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);
       
        if(request()->ajax() && request()->has('status')) {
            $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email, request('status'));
            return view('Client.partials.reservations-grid', compact('allReservations'));
        }
        
        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getReviewsAboutMe($user->email);
        $profile = ClientModel::getClientProfile($user->email); 

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);



        return view('Client.Components.AllReservation',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification'));
            
    }

    function ShowAvisRecusClient () {
        $user = Auth::user();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);
       
        if(request()->ajax() && request()->has('status')) {
            $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email, request('status'));
            return view('Client.partials.reservations-grid', compact('allReservations'));
        }
        
        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getReviewsAboutMe($user->email);
        $profile = ClientModel::getClientProfile($user->email); 

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);



        return view('Client.Components.Avis',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification'));
            
    }

    
    function ShowEquipementRecommendeClient () {
        $user = Auth::user();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);
       
        if(request()->ajax() && request()->has('status')) {
            $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email, request('status'));
            return view('Client.partials.reservations-grid', compact('allReservations'));
        }
        
        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getReviewsAboutMe($user->email);
        $profile = ClientModel::getClientProfile($user->email); 

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);



        return view('Client.Components.Equipements_recommande',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification'));
            
    }
    function ShowProfileClient () {
        $user = Auth::user();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);
        $cities = PartenaireModel::getCities();

        if(request()->ajax() && request()->has('status')) {
            $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email, request('status'));
            return view('Client.partials.reservations-grid', compact('allReservations'));
        }
        
        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getReviewsAboutMe($user->email);
        $profile = ClientModel::getClientProfile($user->email); 

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);



        return view('Client.Components.Profile',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification','cities'));
            
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        'phone_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|max:255',
        'confirm_password' => 'required_with:password|same:password',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_subscriber' =>'nullable',
        'city_id'=>'nullable',
    ]);

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }
    unset($validated['confirm_password']);

    if ($request->hasFile('avatar')) {

        $file = $request->file('avatar');

        $filePath = $file->store('profile_images', 'public');

        $validated['avatar_url'] = 'storage/' . $filePath;
    }

    $user->update($validated);

    if ($request->expectsJson()) {
        return response()->json(['success' => true]);
    }

    return redirect()->route('HomeClient.profile')->with('success', 'Profil mis à jour avec succès.');
}



    public function cancel($id)
{
    try {
        // 1. Find the reservation (or fail with 404)
        $reservation = Reservation::findOrFail($id);

        // 2. Check if already canceled (optional)
        if ($reservation->status === 'canceled') {
            return response()->json([
                'success' => false,
                'message' => 'La réservation est déjà annulée.'
            ], 400);
        }

        // 3. Update status (wrap in transaction if needed)
        $reservation->update(['status' => 'canceled']);

        // 4. Return success
        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée avec succès.'
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Specific error for missing reservation
        return response()->json([
            'success' => false,
            'message' => 'Réservation introuvable.'
        ], 404);

    } catch (\Exception $e) {
        // Generic server error
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'annulation: ' . $e->getMessage()
        ], 500);
    }
}
}