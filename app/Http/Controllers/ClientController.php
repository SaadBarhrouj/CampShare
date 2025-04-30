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

use App\Models\Review;
use App\Models\User;


class ClientController extends Controller
{
    function ShowHomeClient () {
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

        $reviews = ClientModel::getClientReviewsWithTargets($user->email);

        $profile = ClientModel::getClientProfile($user->email); 


        return view('Client.tablea_de_bord_client',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'user' => $user
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