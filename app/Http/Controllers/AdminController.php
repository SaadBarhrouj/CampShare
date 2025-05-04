<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Compter directement sans charger tous les modèles (plus efficace)
        $clientsCount = User::where('role', 'client')->count();
        $partnersCount = User::where('role', 'partner')->count();

        // Compter les équipements (items) et catégories
        $itemsCount = DB::table('items')->count();
        $categoriesCount = DB::table('categories')->count();

        // Récupérer les utilisateurs récents (clients et partenaires)
        $recentUsers = User::whereIn('role', ['client', 'partner'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', [
            'clientsCount' => $clientsCount,
            'partnersCount' => $partnersCount,
            'itemsCount' => $itemsCount,
            'categoriesCount' => $categoriesCount,
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

        // Pour les partenaires, récupérer leurs équipements (items)
        if ($user->role === 'partner') {
            $items = DB::table('items')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->where('items.partner_id', $userId)
                ->select(
                    'items.*',
                    'categories.name as category_name'
                )
                ->orderBy('items.created_at', 'desc')
                ->get();
        } else {
            $items = collect();
        }

        // Récupérer les réservations (pour clients et partenaires)
        $reservations = DB::table('reservations')
            ->where('client_id', $userId)
            ->orWhere('partner_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'user' => $user,
            'items' => $items,
            'reservations' => $reservations
        ]);
    }

    public function clients(Request $request)
    {
        $query = User::where('role', 'client')
            ->with(['city'])
            ->withCount(['reservations']);

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
                    $query->orderBy('reservations_count', 'desc');
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
            'reservations' => DB::table('reservations')->count(),
        ];

        return view('admin.liste-clients-admin', compact('clients', 'stats'));
    }

    public function partners(Request $request)
    {
        $query = User::where('role', 'partner')
            ->with(['city', 'items'])
            ->withCount([
                'items',
                'reservations'
            ]);

        // Filtre de recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('city', function ($q) use ($search) {
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
            'equipment-count' => ['items_count', 'desc'],
            'reservation-count' => ['reservations_count', 'desc']
        ];

        $sort = $request->input('sort', 'recent');
        $sortOption = $sortOptions[$sort] ?? $sortOptions['recent'];
        $query->orderBy($sortOption[0], $sortOption[1]);

        $partners = $query->paginate(10);

        // Statistiques
        $stats = [
            'total' => User::where('role', 'partner')->count(),
            'equipment_count' => DB::table('items')->count(),
            'revenue' => DB::table('payments')->sum('amount') ?? 0
        ];

        return view('admin.partners', compact('partners', 'stats', 'sort', 'request'));
    }

    public function updateReservationStatus($reservationId, Request $request)
    {
        // Valider les données
        $request->validate([
            'status' => 'required|in:pending,confirmed,ongoing,canceled,completed'
        ]);

        // Mettre à jour la réservation
        DB::table('reservations')
            ->where('id', $reservationId)
            ->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function getRecentEquipments()
    {
        $equipments = Item::with(['partner', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'partner_name' => $item->id, // Supposant que le partenaire a un champ 'name'
                    'price_per_day' => $item->price_per_day,
                    'category_name' => $item->category->name, // Supposant que la catégorie a un champ 'name'
                    'created_at' => $item->created_at
                ];
            });

        return response()->json($equipments);
    }
    
   

public function getRecentReservations()
{
    try {
        $reservations = Reservation::with(['client', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($reservation) {
                return [
                    'client_name' => $reservation->delivery_option ?? 'Inconnu',
                    'equipment_title' => $reservation->updated_at ?? 'Équipement supprimé',
                    'start_date' => \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y'),
                    'end_date' => \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y'),
                    'total_price' => $reservation->partner_id,
                    'status' => $reservation->status,
                    'created_at' => $reservation->created_at
                ];
            });

        return response()->json($reservations);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erreur serveur',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function showEquipment($id)
{
    $equipment = Item::with('images')->findOrFail($id);
    
    return view('admin.equipment.show', compact('equipment'));
}



}