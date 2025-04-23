<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class PartnerDashboardApiController extends Controller
{
    /**
     * Récupérer les données du tableau de bord pour le partenaire avec ID=21
     */
    public function index()
    {
        // Récupérer le partenaire avec ID=21
        $partner = User::with('city')->findOrFail(21);
        
        // Récupérer les annonces du partenaire
        $listings = Listing::where('partner_id', 21)
                          ->with(['images', 'category', 'city'])
                          ->latest()
                          ->get();
        
        // Récupérer les réservations du partenaire
        $reservations = Reservation::where('partner_id', 21)
                                  ->with(['client', 'listing', 'listing.images'])
                                  ->latest()
                                  ->take(10)
                                  ->get();
        
        // Récupérer les demandes de location en attente
        $pendingReservations = Reservation::where('partner_id', 21)
                                        ->where('status', 'pending')
                                        ->with(['client', 'listing', 'listing.images'])
                                        ->latest()
                                        ->get();
        
        // Récupérer les avis reçus
        $reviews = Review::whereHas('reservation', function($query) {
                            $query->where('partner_id', 21);
                        })
                        ->with(['reservation.client', 'reservation.listing'])
                        ->latest()
                        ->take(5)
                        ->get();
        
        // Calculer les statistiques
        $totalListings = $listings->count();
        $totalReservations = Reservation::where('partner_id', 21)->count();
        $totalRevenue = Reservation::where('reservations.partner_id', 21)
                                  ->where('reservations.status', 'completed')
                                  ->join('listings', 'reservations.listing_id', '=', 'listings.id')
                                  ->select(DB::raw('SUM(listings.price_per_day * DATEDIFF(reservations.end_date, reservations.start_date)) as total_revenue'))
                                  ->first()
                                  ?->total_revenue ?? 0;
        
        $averageRating = $partner->avg_rating ?? 0;
        
        // Récupérer l'activité récente (combinaison de réservations et d'avis)
        $recentActivity = collect();
        
        // Ajouter les réservations récentes à l'activité
        foreach($reservations->take(3) as $reservation) {
            $recentActivity->push([
                'type' => 'reservation',
                'data' => $reservation,
                'created_at' => $reservation->created_at
            ]);
        }
        
        // Ajouter les avis récents à l'activité
        foreach($reviews->take(3) as $review) {
            $recentActivity->push([
                'type' => 'review',
                'data' => $review,
                'created_at' => $review->created_at
            ]);
        }
        
        // Trier l'activité par date
        $recentActivity = $recentActivity->sortByDesc('created_at')->take(5)->values();
        
        // Retourner les données au format JSON
        return response()->json([
            'partner' => $partner,
            'listings' => $listings,
            'reservations' => $reservations,
            'pendingReservations' => $pendingReservations,
            'reviews' => $reviews,
            'totalListings' => $totalListings,
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'averageRating' => $averageRating,
            'recentActivity' => $recentActivity
        ]);
    }
}
