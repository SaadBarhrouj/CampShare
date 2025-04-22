<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $clientsCount = User::where('role', 'client')->count();
        $clients = User::where('role', 'client')
                      ->with('city')
                      ->get();
        $partnersCount = User::where('role', 'partner')->count();

        return view('admin.dashboard', compact('clients', 'clientsCount','partnersCount'));
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
            'spending' => \App\Models\Payment::sum('amount')
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
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('username', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('city', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
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
    
        return view('admin.partners', compact('partners', 'stats', 'sort','request'));
    }

}