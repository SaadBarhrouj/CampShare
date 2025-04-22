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
                      
        return view('admin.dashboard', compact('clients', 'clientsCount'));
    }

    public function clients(Request $request)
    {
        $query = User::where('role', 'client')
            ->with(['city', 'receivedReviews', 'clientReservations'])
            ->withCount(['receivedReviews', 'clientReservations']);
    
        // Ajoutez la recherche si un terme est fourni
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('username', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        $clients = $query->paginate(10);
    
        $stats = [
            'total' => User::where('role', 'client')->count(),
            'reservations' => \App\Models\Reservation::count(),
            'spending' => \App\Models\Payment::sum('amount')
        ];
        
        return view('admin.liste-clients-admin', compact('clients', 'stats'));
    }

}