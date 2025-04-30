<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Image;
use App\Models\Review;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CleanupController extends Controller
{
    public function cleanAllEquipments()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }
        
        // Récupérer tous les équipements du partenaire
        $items = Item::where('partner_id', $user->id)->get();
        
        $count = 0;
        $errors = [];
        
        foreach ($items as $item) {
            try {
                // Supprimer d'abord les listings (annonces) qui référencent cet équipement
                $listings = Listing::where('item_id', $item->id)->get();
                foreach ($listings as $listing) {
                    // Supprimer les réservations associées à ce listing
                    Reservation::where('listing_id', $listing->id)->delete();
                    Log::info("Réservations supprimées pour le listing ID: " . $listing->id);
                    
                    // Supprimer le listing
                    $listing->delete();
                    Log::info("Listing supprimé: " . $listing->id);
                }
                
                // Supprimer les images associées
                foreach ($item->images as $image) {
                    // Essayer de supprimer le fichier physique
                    try {
                        $path = str_replace('/storage/', '', $image->url);
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                            Log::info("Image supprimée: " . $path);
                        }
                    } catch (\Exception $e) {
                        Log::error("Erreur lors de la suppression de l'image: " . $e->getMessage());
                    }
                    
                    // Supprimer l'enregistrement de l'image
                    $image->delete();
                }
                
                // Supprimer les avis associés
                foreach ($item->reviews as $review) {
                    $review->delete();
                }
                
                // Supprimer l'équipement
                $item->delete();
                Log::info("Équipement supprimé: " . $item->id);
                $count++;
            } catch (\Exception $e) {
                $errorMsg = "Erreur lors de la suppression de l'équipement ID {$item->id} : " . $e->getMessage();
                Log::error($errorMsg);
                $errors[] = $errorMsg;
            }
        }
        
        if (count($errors) > 0) {
            return redirect()->route('HomePartenaie')->with('error', "Des erreurs sont survenues lors de la suppression : " . implode(", ", array_slice($errors, 0, 3)) . (count($errors) > 3 ? " et " . (count($errors) - 3) . " autres erreurs." : ""));
        }
        
        return redirect()->route('HomePartenaie')->with('success', $count . ' équipements ont été supprimés avec succès.');
    }
    
    public function fixImageStorage()
    {
        // Vérifier si le dossier storage/app/public/equipment_images existe
        if (!Storage::disk('public')->exists('equipment_images')) {
            Storage::disk('public')->makeDirectory('equipment_images');
            Log::info("Dossier equipment_images créé");
        }
        
        // Vérifier si le lien symbolique existe
        $publicPath = public_path('storage');
        if (!file_exists($publicPath)) {
            Log::info("Lien symbolique manquant, exécution de storage:link");
            // Nous ne pouvons pas exécuter directement la commande Artisan ici
            // Mais nous pouvons suggérer à l'utilisateur de le faire
        }
        
        return redirect()->route('HomePartenaie')->with('success', 'Vérification du stockage des images terminée. Si les images ne s\'affichent toujours pas, exécutez "php artisan storage:link" dans votre terminal.');
    }
}
