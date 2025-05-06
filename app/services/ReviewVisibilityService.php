<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReviewVisibilityService
{
    const VISIBILITY_DELAY_DAYS = 7; 

    /**
     * Met à jour la visibilité des avis mutuels (client <-> partenaire).
     * Appelé après la soumission d'un avis 'forPartner' ou 'forClient'.
     */
    public function updateVisibilityForReservation(Reservation $reservation): void
    {
        $reviews = $reservation->reviews()
                        ->whereIn('type', ['forClient', 'forPartner'])
                        ->get();

        if ($reviews->count() < 2) {
            Log::debug("[Visibility Service] Res ID {$reservation->id}: Not enough reviews for mutual check.");
            return;
        }

        $clientReview = $reviews->firstWhere('type', 'forPartner');
        $partnerReview = $reviews->firstWhere('type', 'forClient');

        if ($clientReview && $partnerReview) {
            $updated = false;
            if (!$clientReview->is_visible) {
                $clientReview->update(['is_visible' => true]);
                $updated = true;
            }
            if (!$partnerReview->is_visible) {
                $partnerReview->update(['is_visible' => true]);
                $updated = true;
            }
            if ($updated) {
                 Log::info("[Visibility Service] Res ID {$reservation->id}: Mutual reviews made visible.");
            }
        } else {
             Log::debug("[Visibility Service] Res ID {$reservation->id}: Mutual reviews not yet complete.");
        }
    }

     /**
      * Rend un avis spécifique visible (utilisé par la tâche planifiée).
      */
     public function makeReviewVisible(Review $review): bool
     {
         if (!$review->is_visible) {
             $review->update(['is_visible' => true]);
             Log::info("[Visibility Service - Scheduler] Made Review ID {$review->id} (Type: {$review->type}) visible after delay.");
             return true;
         }
         return false;
     }
}