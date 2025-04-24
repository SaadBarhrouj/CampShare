<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability; // Import the LeaveRequest model
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\PartenaireModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Review;


class PartenaireController extends Controller
{
    public function ShowHomePartenaire()
{
    $user = Auth::user();

    $sumPayment = PartenaireModel::getMonthlyPaymentsSumPartenaire($user->email);
    $NumberReservation = PartenaireModel::getNumberReservation($user->email);
    $AverageRating = PartenaireModel::getAverageRating($user->email);
    $TotalAvis = PartenaireModel::getNumberRating($user->email);
    $TotalListing = PartenaireModel::countListingsByEmail($user->email);
    $pendingReservation = PartenaireModel::getPendingReservationsWithMontantTotal($user->email);
    $TotalListingActive = PartenaireModel::countActiveListingsByEmail($user->email);
    $RecentListing = PartenaireModel::getRecentPartnerListingsWithImagesByEmail($user->email);
    $AllReservationForPartner = PartenaireModel::getPartenerDemandeReservation($user->email);
    $AllEquipement = PartenaireModel::getPartenerEquipement($user->email);
    $NumberPendingReservation = PartenaireModel::getNumberOfPendingReservation($user->email);
    $NumberOfPartenaireEquipement = PartenaireModel::getNumberOfPartenaireEquipement($user->email);
    $LocationsEncours = PartenaireModel::getLocationsEncours($user->email);
    $NumberLocationsEncours= PartenaireModel::getNumberLocationsEncours($user->email);


    return view('Partenaire.tablea_de_bord_partenaire', compact(
        'user',
        'sumPayment',
        'NumberReservation',
        'AverageRating',
        'TotalAvis',
        'TotalListing',
        'pendingReservation',
        'TotalListingActive',
        'RecentListing',
        'AllReservationForPartner',
        'AllEquipement',
        'NumberPendingReservation',
        'NumberOfPartenaireEquipement',
        'LocationsEncours',
        'NumberLocationsEncours'

    ));
}

public function filter(Request $request)
{
    
    // Start the query on the Users table
    $demandes = User::query();

    // Join the Reservations table with the appropriate condition
    $demandes = $demandes->join('Reservations', 'Reservations.partner_id', '=', 'users.id')
        ->join('Listings', 'Reservations.listing_id', '=', 'Listings.id')
        ->join('users as Client', 'Reservations.client_id', '=', 'Client.id');

    $email = $request->input('email');
    $demandes = $demandes->where('users.email', $email);
    if ($request->has('status')) {
        if ($request->input('status') !== 'all') {
            $demandes = $demandes->where('Reservations.status', $request->input('status'));
        }
    }
    if ($request->has('date')) {
        $today = Carbon::today();

        if ($request->input('date') == 'this-month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-month') {
            $start = Carbon::now()->subMonth()->startOfMonth();
            $end = Carbon::now()->subMonth()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-3-months') {
            $start = Carbon::now()->subMonths(3)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);
        }
    }
    if ($request->has('sort')) {
        if ($request->input('sort') == 'date-desc') {
            $demandes = $demandes->orderByDesc('reservations.created_at');
        } else {
            $demandes = $demandes->orderBy('reservations.created_at');
        }
    }
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $demandes = $demandes->where('Listings.title', 'like', '%' . $searchTerm . '%');
    }
    





    $demandes = $demandes->get();
    return response()->json([
        'success' => true,
        'demandes' => $demandes, // This will return the raw data (e.g., collection of User models)
    ]);
}

public function handleAction(Request $request)
{
    $reservation = Reservation::findOrFail($request->reservation_id);

    if ($request->action === 'accept') {
        $reservation->status = 'confirmed';
    } elseif ($request->action === 'refuse') {
        $reservation->status = 'canceled';
    }

    $reservation->save();

    return back()->with('success', 'Action effectuée avec succès.');
}
    

    
}
