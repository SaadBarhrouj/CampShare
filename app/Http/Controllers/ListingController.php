<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Image;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Affiche le formulaire de création d'annonce
     */
    public function create(Request $request)
    {
        $editMode = false;
        $listing = null;
        
        // Vérifier si on est en mode édition
        if ($request->has('edit')) {
            $editMode = true;
            
            // Récupérer l'annonce à éditer
            $listing = Listing::with('images')->where('id', $request->edit)
                             ->where('partner_id', 21)
                             ->first();
            
            if (!$listing) {
                return redirect()->route('partner.equipment')
                    ->with('error', 'Annonce non trouvée.');
            }
        }
        
        // Récupérer toutes les catégories et villes depuis la base de données
        $categories = Category::all();
        $cities = City::all();
        
        return view('annonce-form', compact('editMode', 'listing', 'categories', 'cities'));
    }

    /**
     * Enregistre une nouvelle annonce ou met à jour une annonce existante
     */
    public function store(Request $request)
    {
        try {
            // Log complet de la requête pour déboguer
            Log::info('Début de la création/modification d\'une annonce', [
                'request' => $request->except(['photos']),
                'has_files' => $request->hasFile('photos'),
                'files_count' => $request->hasFile('photos') ? count($request->file('photos')) : 0,
                'all_files' => $request->allFiles()
            ]);
            
            // Validation des données
            $validator = Validator::make($request->all(), [
                'equipment_name' => 'required|string|max:255',
                'category' => 'required',
                'city' => 'required',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation échouée', ['errors' => $validator->errors()]);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // Vérifier s'il s'agit d'une mise à jour d'une annonce existante
            $listing = null;
            if ($request->has('listing_id')) {
                $listing = Listing::where('id', $request->listing_id)
                                 ->where('partner_id', 21)
                                 ->first();
                
                if (!$listing) {
                    Log::error('Annonce non trouvée pour mise à jour', ['listing_id' => $request->listing_id]);
                    return redirect()->back()
                        ->with('error', 'Annonce non trouvée.')
                        ->withInput();
                }
                
                Log::info('Mise à jour d\'une annonce existante', ['listing_id' => $listing->id]);
            } else {
                // Création d'une nouvelle annonce
                $listing = new Listing();
                $listing->partner_id = 21; // ID du partenaire fixe
                Log::info('Création d\'une nouvelle annonce');
            }
            
            // Préparation de la description enrichie avec les informations supplémentaires
            $enrichedDescription = $request->description . "\n\n";
            
            if ($request->brand) {
                $enrichedDescription .= "Marque: " . $request->brand . "\n";
            }
            
            if ($request->capacity) {
                $enrichedDescription .= "Capacité: " . $request->capacity . "\n";
            }
            
            if ($request->has('available-from') && $request->has('available-until')) {
                $enrichedDescription .= "Disponible du: " . date('d/m/Y', strtotime($request->input('available-from'))) . 
                                      " au " . date('d/m/Y', strtotime($request->input('available-until'))) . "\n";
            }

            // Mise à jour des champs de l'annonce
            $listing->title = $request->equipment_name;
            $listing->category_id = $request->category;
            $listing->city_id = $request->city;
            $listing->price_per_day = $request->price;
            $listing->description = $enrichedDescription;
            $listing->status = 'active';
            $listing->delivery_option = $request->has('delivery_option') ? 1 : 0;

            // Gestion des options premium
            if ($request->has('is_premium') && $request->is_premium == '1') {
                $listing->is_premium = 1;
                $listing->premium_start_date = now();
                $listing->premium_end_date = now()->addDays(30); // Premium pendant 30 jours
            } else {
                $listing->is_premium = 0;
                $listing->premium_start_date = now();
                $listing->premium_end_date = now();
            }

            $listing->save();
            
            Log::info('Annonce créée ou mise à jour avec succès', ['listing_id' => $listing->id, 'listing_data' => $listing->toArray()]);

            // Gestion des photos
            if ($request->hasFile('photos')) {
                Log::info('Photos détectées dans la requête', ['count' => count($request->file('photos'))]);
                
                // Si c'est une mise à jour et que l'utilisateur a demandé de supprimer les anciennes photos
                if ($request->has('listing_id') && $request->has('replace_photos')) {
                    // Supprimer les anciennes photos
                    $oldImages = Image::where('listing_id', $listing->id)->get();
                    foreach ($oldImages as $oldImage) {
                        // Supprimer le fichier physique
                        if (Storage::disk('public')->exists($oldImage->url)) {
                            Storage::disk('public')->delete($oldImage->url);
                        }
                        // Supprimer l'enregistrement
                        $oldImage->delete();
                    }
                    Log::info('Anciennes photos supprimées', ['listing_id' => $listing->id]);
                }
                
                $mainPhotoIndex = $request->has('main_photo') ? $request->main_photo : 0;
                $photos = $request->file('photos');
                
                foreach ($photos as $index => $photo) {
                    // Vérifier que le fichier est valide
                    if (!$photo->isValid()) {
                        Log::error('Photo invalide', ['index' => $index, 'error' => $photo->getError()]);
                        continue;
                    }
                    
                    // Générer un nom de fichier unique
                    $filename = time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    
                    // Stocker le fichier dans le dossier public/storage/listings
                    if (!Storage::disk('public')->exists('listings')) {
                        Storage::disk('public')->makeDirectory('listings');
                    }
                    
                    // Stocker le fichier
                    $path = $photo->storeAs('listings', $filename, 'public');
                    
                    // Créer un enregistrement dans la table images
                    $image = new Image();
                    $image->listing_id = $listing->id;
                    $image->url = $path; // Stocker le chemin relatif
                    $image->save();
                    
                    // Si c'est la photo principale, mettre à jour la description pour le mentionner
                    if ($index == $mainPhotoIndex) {
                        $mainPhotoUrl = asset('storage/' . $path);
                        $listing->description .= "\n\nPhoto principale: " . $mainPhotoUrl;
                        $listing->save();
                    }
                    
                    Log::info('Photo enregistrée', [
                        'path' => $path, 
                        'url' => $image->url, 
                        'is_main' => ($index == $mainPhotoIndex) ? 'yes' : 'no',
                        'image_id' => $image->id,
                        'public_url' => asset('storage/' . $path)
                    ]);
                }
            } else {
                Log::warning('Aucune photo n\'a été téléchargée ou le champ photos[] n\'existe pas dans la requête');
                Log::info('Contenu de la requête', ['files' => $request->allFiles()]);
            }

            // Redirection vers la page de succès
            return redirect()->route('listing.success');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'annonce', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de votre annonce. Veuillez réessayer.')
                ->withInput();
        }
    }

    /**
     * Affiche la page de succès après la création d'une annonce
     */
    public function success()
    {
        return view('listing-success');
    }
}
