<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexClientProfile(User $user)
    {
        if ($user->role !== 'client') {
            abort(403, 'Unauthorized. Ce n\'est pas un client.');
        }

        $reservationsCount = $user->clientReservations()->count();

        return view('client.profiles.clientProfile', compact('user', 'reservationsCount'));
    }


    /**
     * Display a listing of the resource.
     */
    public function indexPartnerProfile(User $user)
    {
        if ($user->role !== 'partner') {
            abort(403, 'Unauthorized. Ce n\'est pas un partenaire.');
        }

        // Get all item IDs that belong to the partner
        $itemIds = $user->items->pluck('id');

        // Get all listings that belong to the partner's items
        $listings = Listing::whereIn('item_id', $itemIds)->where('status', 'active')->latest()->get();

        $listingsCount = $listings->count();

        return view('client.profiles.partnerProfile', compact('user', 'listings', 'listingsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
