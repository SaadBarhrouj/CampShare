<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability; // Import the LeaveRequest model
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\PartenaireModel;
use App\Models\ClientModel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Review;

class PartenaireController extends Controller
{
    public function ShowHomePartenaire()
{

    $user = Auth::user();


    $sumPayment = PartenaireModel::sumPaymentThisMonth($user->email);
    $NumberReservationCompleted = PartenaireModel::getNumberCompletedReservation($user->email);
    $AverageRating = PartenaireModel::getAverageRatingPartner($user->email);
    $TotalAvis = PartenaireModel::getCountRatingPartner($user->email);
    $TotalListing = PartenaireModel::countListingsByEmail($user->email);
    $TotalListingActive = PartenaireModel::countActiveListingsByEmail($user->email);

    $pendingReservation = PartenaireModel::getPendingReservationsWithMontantTotal($user->email);
    $RecentListing = PartenaireModel::getRecentPartnerListingsWithImagesByEmail($user->email);
    $AllReservationForPartner = PartenaireModel::getPartenerDemandeReservation($user->email);
    $AllEquipement = PartenaireModel::getPartenerEquipement($user->email);
    $NumberPendingReservation = PartenaireModel::getNumberOfPendingReservation($user->email);
    $NumberOfPartenaireEquipement = PartenaireModel::getNumberOfPartenaireEquipement($user->email);
    $LocationsEncours = PartenaireModel::getLocationsEncours($user->email);
    $NumberLocationsEncours= PartenaireModel::getNumberLocationsEncours($user->email);
    $LesAvis= PartenaireModel::getAvis($user->email);
    $categories = Category::all();
    $notifications = (new NotificationController)->getNotifUser($user->id);
    $totalNotification = (new NotificationController)->totalNotification($user->id);
    $lastAvisPartnerForObjet = PartenaireModel::getLastAvisPartnerForObject($user->email);
    $profile = ClientModel::getClientProfile($user->email); 

    return view('Partenaire.tablea_de_bord_partenaire', compact(
        'user',
        'sumPayment',
        'NumberReservationCompleted',
        'AverageRating',
        'TotalAvis',
        'TotalListing',
        'pendingReservation',
        'TotalListingActive',
        'RecentListing',
        'AllReservationForPartner',
        'AllEquipement',
        'NumberPendingReservation',
        'NumberOfPartenaireEquipement',
        'LocationsEncours',
        'NumberLocationsEncours',
        'LesAvis',
        'categories' ,
        'notifications',
        'totalNotification',
        'lastAvisPartnerForObjet',
        'profile'
    ));
}
public function devenir_partenaire(){
    $user = Auth::user();
    PartenaireModel::updaterole($user->email);
    return redirect()->route('HomePartenaie');
}




public function filter(Request $request)
{
    
    // Start the query on the Users table
    $demandes = User::query();

    $demandes = $demandes->join('Reservations', 'Reservations.partner_id', '=', 'users.id')
        ->join('Listings', 'Reservations.listing_id', '=', 'Listings.id')
        ->join('items', 'items.id', '=', 'Listings.item_id')
        ->join('users as Client', 'Reservations.client_id', '=', 'Client.id');

    $email = $request->input('email');
    $demandes = $demandes->where('users.email', $email);
    if ($request->has('status')) {
        if ($request->input('status') !== 'all') {
            $demandes = $demandes->where('Reservations.status', $request->input('status'));
        }
    }
    if ($request->has('date')) {
        $today = Carbon::today();

        if ($request->input('date') == 'this-month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-month') {
            $start = Carbon::now()->subMonth()->startOfMonth();
            $end = Carbon::now()->subMonth()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-3-months') {
            $start = Carbon::now()->subMonths(3)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);
        }
    }
    if ($request->has('sort')) {
        if ($request->input('sort') == 'date-desc') {
            $demandes = $demandes->orderByDesc('Reservations.created_at');
        } else {
            $demandes = $demandes->orderBy('Reservations.created_at');
        }
    }
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $demandes = $demandes->where('items.title', 'like', '%' . $searchTerm . '%');
    }
    $demandes = $demandes->select(
        'Client.avatar_url',
        'Client.username',
        'items.title',
        'items.price_per_day',
        'Reservations.status',
        'Reservations.start_date',
        'Reservations.end_date',
        'Reservations.created_at',
        'Reservations.id',
        DB::raw('DATEDIFF(Reservations.end_date, Reservations.start_date) * items.price_per_day AS montant_total'),
        DB::raw('DATEDIFF(Reservations.end_date, Reservations.start_date) AS number_days')
    );
    $demandes = $demandes->get();
    Log::info('Demandes: ', $demandes->toArray());

    return response()->json([
        'success' => true,
        'demandes' => $demandes, 
    ]);
}
public function filterLocationEnCours(Request $request)
{
    
    $demandes = User::query();
    $demandes = $demandes->join('Reservations', 'Reservations.partner_id', '=', 'users.id')
        ->join('Listings', 'Reservations.listing_id', '=', 'Listings.id')
        ->join('items', 'items.id', '=', 'Listings.item_id')
        ->join('users as Client', 'Reservations.client_id', '=', 'Client.id');

    $email = $request->input('email');
    $demandes = $demandes->where('users.email', $email);
    $demandes = $demandes->where('Reservations.status', "ongoing");

    if ($request->has('date')) {
        $today = Carbon::today();

        if ($request->input('date') == 'this-month') {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-month') {
            $start = Carbon::now()->subMonth()->startOfMonth();
            $end = Carbon::now()->subMonth()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);

        } elseif ($request->input('date') == 'last-3-months') {
            $start = Carbon::now()->subMonths(3)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $demandes = $demandes->whereBetween('Reservations.created_at', [$start, $end]);
        }
    }
    if ($request->has('sort')) {
        if ($request->input('sort') == 'date-desc') {
            $demandes = $demandes->orderByDesc('Reservations.created_at');
        } else {
            $demandes = $demandes->orderBy('Reservations.created_at');
        }
    }
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $demandes = $demandes->where('items.title', 'like', '%' . $searchTerm . '%');
    }
    $demandes = $demandes->select(
        'Client.avatar_url',
        'Client.username',
        'items.title',
        'items.price_per_day',
        'Reservations.status',
        'Reservations.start_date',
        'Reservations.end_date',
        'Reservations.created_at',
        'Reservations.id',
        DB::raw('DATEDIFF(Reservations.end_date, Reservations.start_date) * items.price_per_day AS montant_total'),
        DB::raw('DATEDIFF(Reservations.end_date, Reservations.start_date) AS number_days')
    );
    $demandes = $demandes->get();

    return response()->json([
        'success' => true,
        'demandes' => $demandes, 
    ]);
}

/**
 * Affiche le formulaire de création d'annonce pour un équipement spécifique
 */
public function createAnnonceForm($equipment_id)
{
    $user = Auth::user();
    
    // Récupérer l'équipement spécifique
    $equipment = Item::with('images')->findOrFail($equipment_id);
    
    // Vérifier que l'équipement appartient bien au partenaire connecté
    if ($equipment->partner_id !== $user->id) {
        return redirect()->route('partenaire.equipements')
            ->with('error', 'Vous n\'êtes pas autorisé à créer une annonce pour cet équipement.');
    }
    
    return view('Partenaire.annonce-form', compact('equipment'));
}

/**
 * Enregistre une nouvelle annonce
 */
public function storeAnnonce(Request $request)
{
        // Validation des données
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'city_id' => 'required|exists:cities,id',
            'delivery_option' => 'required|in:pickup,delivery,both',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_premium' => 'nullable',
            'premium_type' => 'nullable|required_if:is_premium,1|in:7 jours,15 jours,30 jours',
            'terms_agree' => 'required'
        ]);

        // Vérifier que l'équipement appartient au partenaire connecté
        $item = Item::findOrFail($request->item_id);
        if ($item->partner_id != auth()->id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à créer une annonce pour cet équipement.');
        }

        // Créer la nouvelle annonce
        $listing = new Listing();
        $listing->item_id = $request->item_id;
        $listing->status = 'active';
        $listing->start_date = $request->start_date;
        $listing->end_date = $request->end_date;
        $listing->city_id = $request->city_id;
        
        // Convertir l'option de livraison en booléen pour la base de données
        // true si delivery ou both, false si pickup uniquement
        $listing->delivery_option = ($request->delivery_option === 'delivery' || $request->delivery_option === 'both');
        
        $listing->latitude = $request->latitude;
        $listing->longitude = $request->longitude;
        
        // Gestion des options premium
        $listing->is_premium = $request->has('is_premium');
        if ($listing->is_premium) {
            $listing->premium_type = $request->premium_type;
            $listing->premium_start_date = now();
        }
        
        $listing->save();
        
        return redirect()->route('partenaire.mes-annonces')->with('success', 'Votre annonce a été publiée avec succès ! Vous pouvez gérer toutes vos annonces dans cette page.');
    }

public function handleAction(Request $request)
{
    $reservation = Reservation::findOrFail($request->reservation_id);

    if ($request->action === 'accept') {
        $reservation->status = 'confirmed';
    } elseif ($request->action === 'refuse') {
        $reservation->status = 'canceled';
    }

    $reservation->save();

    return back()->with('success', 'Action effectuée avec succès.');
}


public function Avisfilter(Request $request)
{
    $reviews = Review::query()
        ->join('users as reviewer', 'reviewer.id', '=', 'reviews.reviewer_id')
        ->join('users as reviewee', 'reviewee.id', '=', 'reviews.reviewee_id')

        ->leftJoin('items', function($join) {
            $join->on('items.id', '=', 'reviews.reviewee_id')
                 ->where('reviews.type', '=', 'forObject');
        });

    // Filter by email (assuming you want reviews for this partner)
    $email = $request->input('email');
    $reviews = $reviews->where('reviewee.email', $email);

    // Filter by type
    if ($request->has('type') && $request->input('type') !== 'all') {
        $reviews = $reviews->where('reviews.type', $request->input('type'));
    }

    // Date filters
    if ($request->has('date')) {
        $today = Carbon::today();

        switch ($request->input('date')) {
            case 'this-month':
                $reviews = $reviews->whereBetween('reviews.created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
                
            case 'last-month':
                $reviews = $reviews->whereBetween('reviews.created_at', [
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth()
                ]);
                break;
                
            case 'last-3-months':
                $reviews = $reviews->whereBetween('reviews.created_at', [
                    Carbon::now()->subMonths(3)->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
        }
    }

    // Sorting
    if ($request->has('sort')) {
        $reviews = $request->input('sort') == 'date-desc'
            ? $reviews->orderByDesc('reviews.created_at')
            : $reviews->orderBy('reviews.created_at');
    }

    // Select fields
    $reviews = $reviews->select([
        'reviewer.avatar_url',
        'reviewer.username',
        'reviews.comment',
        'reviews.rating',
        'reviews.created_at',
        DB::raw('CASE WHEN reviews.type = "forObject" THEN items.title ELSE NULL END as object_title')
    ]);

    $results = $reviews->get();

    return response()->json([
        'success' => true,
        'Avis' => $results,
    ]);
}

public function showEquipements(Request $request)
{
    $user = Auth::user();
    
    // Start building the query
    $query = Item::where('partner_id', $user->id);
    
    // Apply search filter
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }
    
    // Apply category filter
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category_id', $request->category);
    }
    
    // Apply price range filter
    if (($request->has('min_price') && !empty($request->min_price)) || 
        ($request->has('max_price') && !empty($request->max_price))) {
        
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price_per_day', '<=', $request->max_price);
        }
    }
    
    // Apply sorting
    if ($request->has('sort_by') && !empty($request->sort_by)) {
        $sort_by = $request->sort_by;
        if ($sort_by == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort_by == 'price-asc') {
            $query->orderBy('price_per_day', 'asc');
        } elseif ($sort_by == 'price-desc') {
            $query->orderBy('price_per_day', 'desc');
        } elseif ($sort_by == 'title-asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sort_by == 'title-desc') {
            $query->orderBy('title', 'desc');
        }
    } else {
        // Default sorting
        $query->orderBy('created_at', 'desc');
    }
    
    // Execute the query with relationships
    $AllEquipement = $query->with(['category', 'images', 'reviews'])->get();
    
    // Get all categories for the dropdown
    $categories = Category::all();
    
    // Get other data needed for the dashboard view using PartenaireModel methods
    $sumPayment = PartenaireModel::sumPaymentThisMonth($user->email);
    $NumberReservationCompleted = PartenaireModel::getNumberCompletedReservation($user->email);
    $AverageRating = PartenaireModel::getAverageRatingPartner($user->email);
    $TotalAvis = PartenaireModel::getCountRatingPartner($user->email);
    $TotalListing = PartenaireModel::countListingsByEmail($user->email);
    $TotalListingActive = PartenaireModel::countActiveListingsByEmail($user->email);
    $pendingReservation = PartenaireModel::getPendingReservationsWithMontantTotal($user->email);
    $RecentListing = PartenaireModel::getRecentPartnerListingsWithImagesByEmail($user->email);
    $AllReservationForPartner = PartenaireModel::getPartenerDemandeReservation($user->email);
    $NumberPendingReservation = PartenaireModel::getNumberOfPendingReservation($user->email);
    $NumberOfPartenaireEquipement = PartenaireModel::getNumberOfPartenaireEquipement($user->email);
    $LocationsEncours = PartenaireModel::getLocationsEncours($user->email);
    $NumberLocationsEncours = PartenaireModel::getNumberLocationsEncours($user->email);
    $LesAvis = PartenaireModel::getAvis($user->email);
    
    return view('Partenaire.tablea_de_bord_partenaire', compact(
        'user',
        'sumPayment',
        'NumberReservationCompleted',
        'AverageRating',
        'TotalAvis',
        'TotalListing',
        'pendingReservation',
        'TotalListingActive',
        'RecentListing',
        'AllReservationForPartner',
        'AllEquipement',
        'NumberPendingReservation',
        'NumberOfPartenaireEquipement',
        'LocationsEncours',
        'NumberLocationsEncours',
        'LesAvis',
        'categories'
    ));
}

public function createEquipement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price_per_day' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'images' => 'required|array|min:1|max:5',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $user = Auth::user();
    
    $item = new Item();
    $item->partner_id = $user->id;
    $item->title = $request->title;
    $item->description = $request->description;
    $item->price_per_day = $request->price_per_day;
    $item->category_id = $request->category_id;
    $item->save();

    // Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            try {
                // Générer un nom de fichier unique
                $fileName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                
                // Stocker l'image dans le dossier equipment_images
                $path = $imageFile->storeAs('equipment_images', $fileName, 'public');
                
                // Créer l'enregistrement d'image dans la base de données
                $image = new Image();
                $image->item_id = $item->id;
                $image->url = $path; // Stocker uniquement le chemin relatif
                $image->save();
                
                // Log pour débogage
                Log::info('Image ajoutée : ' . $image->url . ' pour l\'équipement ID: ' . $item->id);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'ajout de l\'image : ' . $e->getMessage());
            }
        }
    }

    return redirect()->route('HomePartenaie')->with('success', 'Équipement ajouté avec succès.');
}

public function updateEquipement(Request $request, $item)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price_per_day' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Récupérer l'équipement par ID
    $item = Item::findOrFail($request->equipment_id);

    // Check if the item belongs to the authenticated user
    if ($item->partner_id != Auth::id()) {
        return redirect()->route('HomePartenaie')->with('error', 'Vous n\'êtes pas autorisé à modifier cet équipement.');
    }

    $item->title = $request->title;
    $item->description = $request->description;
    $item->price_per_day = $request->price_per_day;
    $item->category_id = $request->category_id;
    $item->save();

    // Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            try {
                // Générer un nom de fichier unique
                $fileName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                
                // Stocker l'image dans le dossier equipment_images
                $path = $imageFile->storeAs('equipment_images', $fileName, 'public');
                
                // Créer l'enregistrement d'image dans la base de données
                $image = new Image();
                $image->item_id = $item->id;
                $image->url = $path; // Stocker uniquement le chemin relatif
                $image->save();
                
                // Log pour débogage
                Log::info('Image ajoutée : ' . $image->url . ' pour l\'équipement ID: ' . $item->id);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'ajout de l\'image : ' . $e->getMessage());
            }
        }
    }

    return redirect()->route('HomePartenaie')->with('success', 'Équipement mis à jour avec succès.');
}

public function deleteEquipement($item)
{
    // Récupérer l'équipement par ID
    $item = Item::findOrFail($item);

    // Check if the item belongs to the authenticated user
    if ($item->partner_id != Auth::id()) {
        return redirect()->route('HomePartenaie')->with('error', 'Vous n\'êtes pas autorisé à supprimer cet équipement.');
    }

    try {
        // Supprimer d'abord les listings (annonces) qui référencent cet équipement
        $listings = \App\Models\Listing::where('item_id', $item->id)->get();
        foreach ($listings as $listing) {
            // Supprimer les réservations associées à ce listing
            \App\Models\Reservation::where('listing_id', $listing->id)->delete();
            // Supprimer le listing
            $listing->delete();
        }

        // Delete associated images
        foreach ($item->images as $image) {
            // Remove the file from storage if needed
            // Storage::delete(str_replace('/storage/', 'public/', $image->url));
            $image->delete();
        }

        // Delete associated reviews
        foreach ($item->reviews as $review) {
            $review->delete();
        }

        // Delete the item
        $item->delete();

        return redirect()->route('HomePartenaie')->with('success', 'Équipement supprimé avec succès.');
    } catch (\Exception $e) {
        return redirect()->route('HomePartenaie')->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
    }
}

public function getEquipementReviews($item)
{
    // Récupérer l'équipement par ID
    $item = Item::findOrFail($item);

    // Check if the item belongs to the authenticated user
    if ($item->partner_id != Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $reviews = $item->reviews()
        ->with('reviewer')
        ->where('is_visible', true)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'reviews' => $reviews,
        'average_rating' => $item->averageRating()
    ]);
}

public function deleteAllEquipements()
{
    $user = Auth::user();
    
    // Récupérer tous les équipements du partenaire
    $items = Item::where('partner_id', $user->id)->get();
    
    $count = 0;
    $errors = [];
    
    foreach ($items as $item) {
        try {
            // Supprimer d'abord les listings (annonces) qui référencent cet équipement
            $listings = \App\Models\Listing::where('item_id', $item->id)->get();
            foreach ($listings as $listing) {
                // Supprimer les réservations associées à ce listing
                \App\Models\Reservation::where('listing_id', $listing->id)->delete();
                // Supprimer le listing
                $listing->delete();
            }
            
            // Supprimer les images associées
            foreach ($item->images as $image) {
                $image->delete();
            }
            
            // Supprimer les avis associés
            foreach ($item->reviews as $review) {
                $review->delete();
            }
            
            // Supprimer l'équipement
            $item->delete();
            $count++;
        } catch (\Exception $e) {
            $errors[] = "Erreur lors de la suppression de l'équipement ID {$item->id} : " . $e->getMessage();
        }
    }
    
    if (count($errors) > 0) {
        return redirect()->route('HomePartenaie')->with('error', "Des erreurs sont survenues lors de la suppression : " . implode(", ", $errors));
    }
    
    return redirect()->route('HomePartenaie')->with('success', $count . ' équipements ont été supprimés avec succès.');
}

    /**
     * Affiche la liste des annonces du partenaire
     */
    public function mesAnnonces(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer les filtres
        $status = $request->input('status', 'all');
        $sortBy = $request->input('sort_by', 'newest');
        $search = $request->input('search', '');
        
        // Requête de base pour récupérer les annonces du partenaire
        $query = Listing::select('listings.*', 'items.title', 'items.description', 'items.price_per_day', 'cities.name as city_name')
            ->join('items', 'listings.item_id', '=', 'items.id')
            ->join('cities', 'listings.city_id', '=', 'cities.id')
            ->where('items.partner_id', $user->id)
            ->distinct();
        
        // Appliquer les filtres
        if ($status !== 'all') {
            $query->where('listings.status', $status);
        }
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('items.title', 'like', "%{$search}%")
                  ->orWhere('items.description', 'like', "%{$search}%")
                  ->orWhere('cities.name', 'like', "%{$search}%");
            });
        }
        
        // Appliquer le tri
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('listings.created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('items.price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('items.price_per_day', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('listings.created_at', 'desc');
                break;
        }
        
        // Paginer les résultats
        $annonces = $query->paginate(10);
        
        // Charger les images pour chaque annonce
        foreach ($annonces as $annonce) {
            $item = Item::find($annonce->item_id);
            if ($item) {
                $firstImage = $item->images()->first();
                $annonce->image_urls = $firstImage ? $firstImage->url : null;
            }
        }
        
        return view('Partenaire.mes-annonces', compact('annonces', 'status', 'sortBy', 'search'));
    }
    
    /**
     * Archive une annonce (change son statut en 'archived')
     */
    public function archiveAnnonce(Listing $listing)
    {
        // Vérifier que l'annonce appartient au partenaire connecté
        $user = Auth::user();
        $item = Item::find($listing->item_id);
        
        if ($item->partner_id !== $user->id) {
            return redirect()->route('partenaire.mes-annonces')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        // Changer le statut de l'annonce
        $listing->status = 'archived';
        $listing->save();
        
        return redirect()->route('partenaire.mes-annonces')
            ->with('success', 'L\'annonce a été archivée avec succès.');
    }
    
    /**
     * Supprime une annonce
     */
    public function deleteAnnonce(Listing $listing)
    {
        // Vérifier que l'annonce appartient au partenaire connecté
        $user = Auth::user();
        $item = Item::find($listing->item_id);
        
        if ($item->partner_id !== $user->id) {
            return redirect()->route('partenaire.mes-annonces')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette annonce.');
        }
        
        // Supprimer l'annonce
        $listing->delete();
        
        return redirect()->route('partenaire.mes-annonces')
            ->with('success', 'L\'annonce a été supprimée avec succès.');
    }
    
    /**
     * Met à jour une annonce
     */
    public function updateAnnonce(Request $request, Listing $listing)
    {
        // Vérifier que l'annonce appartient au partenaire connecté
        $user = Auth::user();
        $item = Item::find($listing->item_id);
        
        if ($item->partner_id !== $user->id) {
            return redirect()->route('partenaire.mes-annonces')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        // Si la requête contient uniquement le statut, mettre à jour le statut
        if ($request->has('status')) {
            $listing->status = $request->status;
            $listing->save();
            
            $message = $request->status === 'active' ? 'activée' : ($request->status === 'inactive' ? 'désactivée' : 'mise à jour');
            return redirect()->route('partenaire.mes-annonces')
                ->with('success', 'L\'annonce a été ' . $message . ' avec succès.');
        }
        
        // Valider les données pour une mise à jour complète
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'city_id' => 'required|exists:cities,id',
            'delivery_option' => 'required|in:pickup,delivery,both',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_premium' => 'nullable|boolean',
            'premium_type' => 'nullable|required_if:is_premium,1|in:7 jours,15 jours,30 jours',
        ]);
        
        // Mettre à jour l'annonce
        $listing->start_date = $request->start_date;
        $listing->end_date = $request->end_date;
        $listing->city_id = $request->city_id;
        $listing->delivery_option = ($request->delivery_option === 'delivery' || $request->delivery_option === 'both');
        $listing->latitude = $request->latitude;
        $listing->longitude = $request->longitude;
        
        // Gestion des options premium
        if ($request->has('is_premium')) {
            $listing->is_premium = true;
            $listing->premium_type = $request->premium_type;
            
            // Si l'annonce n'était pas premium avant, définir la date de début
            if (!$listing->is_premium) {
                $listing->premium_start_date = now();
            }
        } else {
            $listing->is_premium = false;
            $listing->premium_type = null;
            $listing->premium_start_date = null;
        }
        
        $listing->save();
        
        return redirect()->route('partenaire.mes-annonces')
            ->with('success', 'L\'annonce a été mise à jour avec succès.');
    }
    
    /**
     * Affiche le formulaire d'édition d'une annonce
     */
    public function editAnnonce(Listing $listing)
    {
        // Vérifier que l'annonce appartient au partenaire connecté
        $user = Auth::user();
        $item = Item::find($listing->item_id);
        
        if ($item->partner_id !== $user->id) {
            return redirect()->route('partenaire.mes-annonces')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
     
        
        // Récupérer les données nécessaires pour le formulaire
        $cities = City::all();
        
        return view('Partenaire.annonce-edit', compact('listing', 'item', 'cities'));
    }

    /**
     * Affiche les détails d'une annonce pour le partenaire
     */
    public function showAnnonceDetails(Listing $listing)
    {
        // Vérifier que l'annonce appartient au partenaire connecté
        $user = Auth::user();
        $item = Item::with('images', 'category')->find($listing->item_id);
        
        if ($item->partner_id !== $user->id) {
            return redirect()->route('partenaire.mes-annonces')
                ->with('error', 'Vous n\'êtes pas autorisé à voir cette annonce.');
        }
        
        // Récupérer la ville
        $city = City::find($listing->city_id);
        
        // Calculer les revenus potentiels
        $startDate = \Carbon\Carbon::parse($listing->start_date);
        $endDate = \Carbon\Carbon::parse($listing->end_date);
        $availableDays = $endDate->diffInDays($startDate);
        $potentialRevenue = $availableDays * $item->price_per_day;
        
        // Récupérer le nombre de vues et de réservations pour cette annonce
        $viewCount = 0; // À implémenter si vous avez un système de suivi des vues
        $reservationCount = Reservation::where('listing_id', $listing->id)->count();
        $completedReservationCount = Reservation::where('listing_id', $listing->id)
            ->where('status', 'completed')
            ->count();
            
        return view('Partenaire.annonce-details', compact(
            'listing',
            'item',
            'city',
            'availableDays',
            'potentialRevenue',
            'viewCount',
            'reservationCount',
            'completedReservationCount'
        ));
    }

    /**
     * Récupère les détails complets d'un équipement
     */
    public function getEquipementDetails($id)
    {
        // Récupérer l'équipement par ID avec ses relations
        $item = Item::with(['images', 'category', 'reviews.reviewer'])->findOrFail($id);

        // Vérifier que l'équipement appartient au partenaire connecté
        if ($item->partner_id != Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Récupérer des statistiques supplémentaires
        $annoncesCount = Listing::where('item_id', $item->id)->count();
        $activeAnnonceCount = Listing::where('item_id', $item->id)->where('status', 'active')->count();
        $reservationsCount = Reservation::whereHas('listing', function($query) use ($item) {
            $query->where('item_id', $item->id);
        })->count();
        $completedReservationsCount = Reservation::whereHas('listing', function($query) use ($item) {
            $query->where('item_id', $item->id);
        })->where('status', 'completed')->count();

        // Calculer le revenu total généré par cet équipement
        $revenue = Reservation::whereHas('listing', function($query) use ($item) {
            $query->where('item_id', $item->id);
        })->where('status', 'completed')
        ->sum(DB::raw('DATEDIFF(end_date, start_date) * ' . $item->price_per_day));

        return response()->json([
            'equipment' => $item,
            'stats' => [
                'annonces_count' => $annoncesCount,
                'active_annonce_count' => $activeAnnonceCount,
                'reservations_count' => $reservationsCount,
                'completed_reservations_count' => $completedReservationsCount,
                'revenue' => $revenue
            ]
        ]);
    }
}