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

        $notifications = (new NotificationController)->getNotifUser($user->id);
        $totalNotification = (new NotificationController)->totalNotification($user->id);
        return view('Client.tablea_de_bord_client',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile','notifications','totalNotification','cities'));
        
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
        'password' => 'nullable|string|min:8|max:255', // Make password optional
        'confirm_password' => 'required_with:password|same:password', // Only required if password exists
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_subscriber' =>'nullable',
        'city_id'=>'nullable',
    ]);

    // Handle password update
    if ($request->filled('password')) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }
    unset($validated['confirm_password']);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar if it exists
        if ($user->avatar_url && File::exists(public_path($user->avatar_url))) {
            File::delete(public_path($user->avatar_url));
        }

        // Ensure directory exists
        if (!File::exists(public_path('images'))) {
            File::makeDirectory(public_path('images'), 0755, true);
        }

        // Store with original filename in public/images
        $file = $request->file('avatar');
        $filename = $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $validated['avatar_url'] = '/images/' . $filename;
    }


    $user->update($validated);
    
    return response()->json([
        'success' => true,
        'user' => $user,
        'avatar_url' => $user->avatar_url // Return updated avatar URL if changed
    ]);
}



    public function cancel($id)
{
    try {
        $reservation = Reservation::findOrFail($id);

        $reservation->update(['status' => 'canceled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée avec succès'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'annulation: ' . $e->getMessage()
        ], 500);
    }
}
}