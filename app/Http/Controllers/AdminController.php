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

    public function clients()
    {
        $clients = User::where('role', 'client')
            ->with(['city', 'receivedReviews', 'clientReservations'])
            ->withCount(['receivedReviews', 'clientReservations'])
            ->get();
            
        return view('admin.liste-clients-admin', compact('clients'));
    }
}