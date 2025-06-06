<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexClientProfile(User $userC)
    {
        if ($userC->role == 'admin') {
            abort(403, 'Unauthorized. Ce n\'est pas un client.');
        }

        $reservationsCount = $userC->clientReservations()->count();

        return view('client.profiles.clientProfile', compact('userC', 'reservationsCount'));
    }


    /**
     * Display a listing of the resource.
     */
    public function indexPartnerProfile(User $userP)
    {
        if ($userP->role !== 'partner' || $userP->role == 'admin') {
            abort(403, 'Unauthorized. Ce n\'est pas un partenaire.');
        }

        // Get all item IDs that belong to the partner
        $itemIds = $userP->items->pluck('id');

        // Get all listings that belong to the partner's items
        $listings = Listing::whereIn('item_id', $itemIds)
            ->where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->whereHas('item.partner', function ($query) {
                    $query->where('is_active', true);
                })
            ->latest()
            ->get();

        $listingsCount = $listings->count();

        return view('client.profiles.partnerProfile', compact('userP', 'listings', 'listingsCount'));
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
