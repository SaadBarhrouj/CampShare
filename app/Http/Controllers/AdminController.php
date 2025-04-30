<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Compter directement sans charger tous les modèles (plus efficace)
        $clientsCount = User::where('role', 'client')->count();
        $partnersCount = User::where('role', 'partner')->count();
    
        // Récupérer les utilisateurs récents (clients et partenaires)
        $recentUsers = User::whereIn('role', ['client', 'partner'])
                          ->latest()
                          ->take(400) // Limiter à 5 utilisateurs récents
                          ->get();
    
        return view('admin.dashboard', [
            'clientsCount' => $clientsCount,
            'partnersCount' => $partnersCount,
            'recentUsers' => $recentUsers,
            'totalUsers' => $clientsCount + $partnersCount
        ]);
    }

    public function updateUserDetails($userId, Request $request)
    {
        // Valider les données
        $request->validate([
            'is_active' => 'required|boolean',
            'admin_notes' => 'nullable|string'
        ]);
    
        // Mettre à jour l'utilisateur
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'is_active' => $request->is_active,
                'admin_notes' => $request->admin_notes,
                'updated_at' => now()
            ]);
    
        return response()->json(['success' => true]);
    }

    public function getUserDetails($userId)
    {

        $user = DB::table('users')
            ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
            ->select('users.*', 'cities.name as city_name')
            ->where('users.id', $userId)
            ->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $reservations = DB::table('reservations')
            ->join('listings', 'reservations.listing_id', '=', 'listings.id')
            ->where('reservations.client_id', $userId)
            ->select(
                'reservations.*',
                'listings.title as listing_title',
                'listings.description as listing_description'
            )
            ->orderBy('reservations.created_at', 'desc')
            ->get();
    
        return response()->json([
            'user' => $user,
            'reservations' => $reservations
        ]);
    }


    public function clients(Request $request)
    {
        $query = User::where('role', 'client')
            ->with(['city', 'receivedReviews', 'clientReservations'])
            ->withCount(['receivedReviews', 'clientReservations']);
        
        // Recherche par nom, email ou ville
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('username', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('city', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }
        
        // Gestion du tri
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'reservation-count':
                    $query->orderBy('client_reservations_count', 'desc');
                    break;
                case 'name-asc':
                    $query->orderBy('username', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('username', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // 'recent' ou autre
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Tri par défaut (plus récents)
            $query->orderBy('created_at', 'desc');
        }
        
        $clients = $query->paginate(10);
        
        $stats = [
            'total' => User::where('role', 'client')->count(),
            'reservations' => \App\Models\Reservation::count(),
            
        ];
        
        return view('admin.liste-clients-admin', compact('clients', 'stats'));
    }

    public function partners(Request $request)
    {
        $query = User::where('role', 'partner')
        ->with(['city', 'equipments', 'receivedReviews'])
        ->withCount([
            'equipments', 
            'partnerReservations', 
            'receivedReviews'
        ]);
    
        // Filtre de recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  // Retirez cette ligne si la colonne phone n'existe pas
                  //->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('city', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
    
      
        // Tri des résultats
        $sortOptions = [
            'recent' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
            'name-asc' => ['username', 'asc'],
            'name-desc' => ['username', 'desc'],
            'equipment-count' => ['equipments_count', 'desc'],
            'reservation-count' => ['partner_reservations_count', 'desc']
        ];
    
        $sort = $request->input('sort', 'recent');
        $sortOption = $sortOptions[$sort] ?? $sortOptions['recent'];
        $query->orderBy($sortOption[0], $sortOption[1]);
        
        $partners = $query->paginate(10);
    
        // Statistiques
        $stats = [
            'total' => User::where('role', 'partner')->count(),
            'equipment_count' => \App\Models\Listing::count(),
            'revenue' => \App\Models\Payment::sum('amount')
        ];
    // Nouveau : Recherche combinée (nom, email, ville)
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('username', 'LIKE', "%{$searchTerm}%") // Nom
              ->orWhere('email', 'LIKE', "%{$searchTerm}%")  // Email
              ->orWhereHas('city', function($q) use ($searchTerm) {
                  $q->where('name', 'LIKE', "%{$searchTerm}%"); // Ville
              });
        });
    }
        return view('admin.partners', compact('partners', 'stats', 'sort','request'));
    }

}