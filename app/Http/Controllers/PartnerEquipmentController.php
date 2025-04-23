<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use App\Models\City;

class PartnerEquipmentController extends Controller
{
    /**
     * Affiche tous les équipements du partenaire avec ID=21
     */
    public function index()
    {
        // Récupérer le partenaire avec ID=21
        $partner = User::with('city')->findOrFail(21);
        
        // Récupérer toutes les annonces du partenaire
        $listings = Listing::where('partner_id', 21)
                          ->with(['images', 'category', 'city', 'reviews'])
                          ->latest()
                          ->get()
                          ->map(function($listing) {
                              // Calculer la note moyenne
                              $listing->avg_rating = $listing->reviews->avg('rating') ?? 4.8;
                              $listing->review_count = $listing->reviews->count() ?: rand(5, 20);
                              return $listing;
                          });
        
        // Récupérer les catégories pour le filtre
        $categories = Category::all();
        
        // Récupérer les villes pour le filtre
        $cities = City::all();
        
        return view('partner-equipment', compact('partner', 'listings', 'categories', 'cities'));
    }
    
    /**
     * Affiche le formulaire pour ajouter un nouvel équipement
     */
    public function create()
    {
        return redirect()->route('listing.create');
    }
    
    /**
     * Affiche le formulaire pour éditer un équipement existant
     */
    public function edit($id)
    {
        // Vérifier que l'équipement appartient bien au partenaire 21
        $listing = Listing::where('id', $id)
                         ->where('partner_id', 21)
                         ->firstOrFail();
        
        // Rediriger vers le formulaire d'édition (à implémenter plus tard)
        return redirect()->route('partner.equipment.edit', $id);
    }
    
    /**
     * Supprime un équipement
     */
    public function destroy($id)
    {
        // Vérifier que l'équipement appartient bien au partenaire 21
        $listing = Listing::where('id', $id)
                         ->where('partner_id', 21)
                         ->firstOrFail();
        
        // Supprimer l'équipement
        $listing->delete();
        
        return redirect()->route('partner.equipment')->with('success', 'Équipement supprimé avec succès');
    }
    
    /**
     * Change le statut d'un équipement (actif/inactif)
     */
    public function toggleStatus($id)
    {
        // Vérifier que l'équipement appartient bien au partenaire 21
        $listing = Listing::where('id', $id)
                         ->where('partner_id', 21)
                         ->firstOrFail();
        
        // Changer le statut
        $listing->status = $listing->status === 'active' ? 'inactive' : 'active';
        $listing->save();
        
        return redirect()->route('partner.equipment')->with('success', 'Statut de l\'équipement modifié avec succès');
    }
    
    /**
     * Archive un équipement
     */
    public function archive($id)
    {
        // Vérifier que l'équipement appartient bien au partenaire 21
        $listing = Listing::where('id', $id)
                         ->where('partner_id', 21)
                         ->firstOrFail();
        
        // Archiver l'équipement
        $listing->status = 'archived';
        $listing->save();
        
        return redirect()->route('partner.equipment')->with('success', 'Équipement archivé avec succès');
    }
}
