<?php

namespace App\Http\Controllers;

// Imports
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use App\Models\Item;
use App\Services\ReviewVisibilityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    protected ReviewVisibilityService $reviewVisibilityService;

    /**
     * Constructeur: Injecte le service de visibilité.
     */
    public function __construct(ReviewVisibilityService $reviewVisibilityService)
    {
        $this->reviewVisibilityService = $reviewVisibilityService;
    }

    /**
     * Affiche le formulaire d'évaluation après vérifications (autorisation, état, délai, existence).
     */
    public function create(Reservation $reservation, Request $request)
    {
        $user = Auth::user();
        $reviewType = $request->query('type'); // type demandé via URL ('review_...')

        // 1. Valider le type d'avis
        if (!in_array($reviewType, ['review_object', 'review_partner', 'review_client'])) {
            abort(400, 'Type d\'avis invalide.');
        }
        $reviewTypeInternal = 'for' . ucfirst(substr($reviewType, 7)); // Conversion en 'for...'

        // 2. Vérifier les autorisations
        $isClient = $user->id === $reservation->client_id;
        $isPartner = $user->id === $reservation->partner_id;
        if (($reviewType === 'review_client' && !$isPartner) ||
            (($reviewType === 'review_object' || $reviewType === 'review_partner') && !$isClient)) {
            abort(403, 'Action non autorisée.');
        }

        // 3. Vérifier si la réservation est évaluable (statut 'completed')
        if ($reservation->status !== 'completed') {
            $redirectRoute = $isPartner ? 'HomePartenaie' : 'HomeClient';
            return redirect()->route($redirectRoute)->with('warning', 'Cette réservation n\'est pas encore évaluable.');
        }

        $endDate = $reservation->end_date instanceof Carbon ? $reservation->end_date : Carbon::parse($reservation->end_date);
        $deadline = $endDate->addDays(ReviewVisibilityService::VISIBILITY_DELAY_DAYS);
        if (Carbon::now()->greaterThan($deadline)) {
            $redirectRoute = $isPartner ? 'HomePartenaie' : 'HomeClient';
            Log::info("Review form access blocked: Deadline passed for Reservation ID {$reservation->id}");
            return redirect()->route($redirectRoute)
                         ->with('info', 'Le délai pour laisser une évaluation pour cette réservation est dépassé.');
        }

        // 4. Vérifier si l'avis existe déjà
        if (Review::where('reservation_id', $reservation->id)->where('reviewer_id', $user->id)->where('type', $reviewTypeInternal)->exists()) {
            $redirectRoute = $isPartner ? 'HomePartenaie' : 'HomeClient';
            return redirect()->route($redirectRoute)->with('info', 'Vous avez déjà soumis cette évaluation.');
        }

        // 5. Préparer les données pour la vue
        $reservation->loadMissing(['listing.item', 'partner', 'client']);
        $itemName = optional(optional($reservation->listing)->item)->title ?? '[Article Supprimé]';
        $pageTitle = ''; $revieweeName = '';
        switch ($reviewType) {
            case 'review_object': $pageTitle = "Évaluer: " . $itemName; break;
            case 'review_partner': $revieweeName = optional($reservation->partner)->username ?? '[Partenaire Inconnu]'; $pageTitle = "Évaluer Partenaire: " . $revieweeName; break;
            case 'review_client': $revieweeName = optional($reservation->client)->username ?? '[Client Inconnu]'; $pageTitle = "Évaluer Client: " . $revieweeName; break;
        }

        return view('reviews.create', compact('reservation', 'reviewType', 'pageTitle', 'itemName', 'revieweeName'));
    }

    /**
     * Enregistre un nouvel avis après validation et vérifications (délai, existence).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Valider les données
        $validatedData = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string|max:1000',
            'review_type'    => ['required', Rule::in(['review_object', 'review_partner', 'review_client'])],
        ]);

        // 2. Récupérer réservation et vérifier état/autorisation
        $reservation = Reservation::with(['client', 'partner', 'listing.item'])->findOrFail($validatedData['reservation_id']);
        $reviewTypeInternal = 'for' . ucfirst(substr($validatedData['review_type'], 7));
        $isClient = $user->id === $reservation->client_id;
        $isPartner = $user->id === $reservation->partner_id;
        if (($reviewTypeInternal === 'forClient' && !$isPartner) || (($reviewTypeInternal === 'forObject' || $reviewTypeInternal === 'forPartner') && !$isClient)) { abort(403); }
        if ($reservation->status !== 'completed') { abort(400, 'Réservation non terminée.'); }

        $endDate = $reservation->end_date instanceof Carbon ? $reservation->end_date : Carbon::parse($reservation->end_date);
        $deadline = $endDate->addDays(ReviewVisibilityService::VISIBILITY_DELAY_DAYS);

        // Vérifier si on essaie de créer un *nouvel* avis après le délai
        $existingReviewCheck = Review::where('reservation_id', $reservation->id)
                                     ->where('reviewer_id', $user->id)
                                     ->where('type', $reviewTypeInternal)->exists();

        if (Carbon::now()->greaterThan($deadline) && !$existingReviewCheck) {
            Log::warning("Review submission blocked: Deadline passed for Reservation ID {$reservation->id}");
            return redirect()->back()->withInput()->with('error', 'Le délai pour soumettre cette évaluation est dépassé.');
        }

        // 3. Re-vérifier si l'avis existe déjà (au cas où)
        if ($existingReviewCheck) { 
            return redirect()->back()->withInput()->with('error', 'Vous avez déjà soumis cette évaluation.');
        }

        // 4. Déterminer IDs et visibilité initiale
        $initialVisibility = ($reviewTypeInternal === 'forObject');
        $revieweeId = null;
        $itemId = null;

        if (!$reservation->listing || !$reservation->listing->item) {
             Log::error("Store Review Error: Listing or Item missing.", ['reservation_id' => $reservation->id]);
             return redirect()->back()->withInput()->with('error', 'Erreur: Article ou annonce introuvable.');
        }
        $itemId = $reservation->listing->item_id;

        switch ($reviewTypeInternal) {
            case 'forPartner': $revieweeId = $reservation->partner_id; if (!$revieweeId) throw new \Exception("ID Partenaire manquant."); break;
            case 'forClient': $revieweeId = $reservation->client_id; if (!$revieweeId) throw new \Exception("ID Client manquant."); break;
            case 'forObject': $revieweeId = $reservation->partner_id; if (!$revieweeId) throw new \Exception("ID Partenaire (objet) manquant."); break;
        }
         if ($revieweeId === null) {
             Log::critical("Reviewee ID null after logic.", ['res_id' => $reservation->id, 'type' => $reviewTypeInternal]);
             return redirect()->back()->withInput()->with('error', 'Erreur critique: Destinataire introuvable.');
         }

        // 5. Transaction DB
        try {
            DB::beginTransaction();

            $review = Review::create([
                'reservation_id' => $reservation->id, 'rating' => $validatedData['rating'],
                'comment' => $validatedData['comment'], 'is_visible' => $initialVisibility,
                'type' => $reviewTypeInternal, 'reviewer_id' => $user->id,
                'reviewee_id' => $revieweeId, 'item_id' => $itemId,
            ]);

            // Marquer la notification comme lue
            $notification = Notification::where('user_id', $user->id)
                                        ->where('reservation_id', $reservation->id)
                                        ->where('type', $validatedData['review_type'])
                                        ->where('is_read', false)->first();
            if ($notification) { $notification->update(['is_read' => true]); }
            else { Log::warning("No unread notification to mark as read.", [/* ... */]); }

            // Appeler le service si ce n'est pas un avis objet
            if (!$initialVisibility) {
                $this->reviewVisibilityService->updateVisibilityForReservation($reservation);
            }

            DB::commit();
            $redirectRoute = $isPartner ? 'HomePartenaie' : 'HomeClient';
            return redirect()->route($redirectRoute)->with('success', 'Merci ! Votre évaluation a été enregistrée.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saving review: " . $e->getMessage(), [ /* ... */ ]);
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }
}