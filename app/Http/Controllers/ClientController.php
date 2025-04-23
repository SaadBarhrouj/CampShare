<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Availability; // Import the LeaveRequest model
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
        $user = User::where('email', 'rajae@gmail.com')->first();
        $totalReservations = ClientModel::totalReservationsByEmail($user->email);
        $totalDepenseByEmail = ClientModel::totalDepenseByEmail($user->email);
        $note_moyenne = ClientModel::noteMoyenneByEmail($user->email);
        $reservations = ClientModel::getReservationDetailsByEmail($user->email);
        $allReservations = ClientModel::getAllReservationDetailsByEmail($user->email);

        $similarListings = ClientModel::getSimilarListingsByCategory($user->email);
        $allSimilarListings = ClientModel::getAllSimilarListingsByCategory($user->email);

        $reviews = ClientModel::getClientReviewsWithTargets($user->email);

        $profile = ClientModel::getClientProfile($user->email); 


        return view('Client.tablea_de_bord_client',compact('totalReservations','totalDepenseByEmail','note_moyenne','user','reservations','allReservations','similarListings','allSimilarListings','reviews','profile'));
    }
   


   
}
