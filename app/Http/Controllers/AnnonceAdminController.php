<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Item;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnonceAdminController extends Controller
{
    public function show($id)
    {
        // Récupérer l'équipement avec ses annonces et images
        $equipment = Item::with(['listings' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'images'])
        ->findOrFail($id);

        // Si vous voulez aussi les informations du partenaire
        $equipment->load('partner');

        return view('admin.annonces.show', [
            'equipment' => $equipment,
            'listings' => $equipment->listings,
            'images' => $equipment->images
        ]);
    }

    public function destroy($id)
{
    DB::beginTransaction();
    
    try {
        $equipment = Item::with([
            'listings.payments',
            'listings.reservations.reviews',
            'images',
            'reviews' 
        ])->findOrFail($id);

      
        foreach ($equipment->listings as $listing) {
            $listing->payments()->delete();
        }

        foreach ($equipment->listings as $listing) {
            foreach ($listing->reservations as $reservation) {
                $reservation->reviews()->delete();
            }
            $listing->reservations()->delete();
        }

        $equipment->listings()->delete();

       
        $equipment->reviews()->delete();

        $equipment->images()->delete();

       
        $equipment->delete();

        DB::commit();

        return redirect()->route('admin.annonces.show')
            ->with('success', 'Équipement et toutes ses données supprimés avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Échec de la suppression: ' . $e->getMessage());
    }
}
}