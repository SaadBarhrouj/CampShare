<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        // Commencer la requête pour récupérer les réservations
        $query = Reservation::with(['client', 'partner', 'listing']);

        // Filtrage par nom ou prénom du client
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->whereHas('client', function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // Récupérer les réservations avec la pagination
        $reservations = $query->paginate(400);

        // Statistiques des réservations groupées par statut
        $reservationStats = DB::table('reservations')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status') // retourne une collection: [status => total]
            ->toArray(); // si tu veux une array associative au lieu d'une collection

        // Transmettre les données à la vue
        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'reservationStats' => $reservationStats,
        ]);
    }
}
