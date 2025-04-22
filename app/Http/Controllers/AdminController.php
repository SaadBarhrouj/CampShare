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
            ->with(['city', 'receivedReviews', 'partnerReservations'])
            ->withCount(['receivedReviews', 'partnerReservations']);
        
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
                    $query->orderBy('partner_reservations_count', 'desc');
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
        
        $partners = $query->paginate(10);
        
        $stats = [
            'total' => User::where('role', 'partner')->count(),
            'active' => User::where('role', 'partner')->count(), // Modifié pour ne pas filtrer sur is_active
            
        ];
        
        return view('admin.partners', compact('partners', 'stats'));
    }

}