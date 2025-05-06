<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User; 
use App\Models\Listing; 
use App\Models\Item; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 

class ReviewNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:send-review-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for ended reservations and send review notifications if no review exists yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = Carbon::yesterday(); 
        $this->info("Starting review notification check for reservations ended on {$targetDate->toDateString()}...");
        Log::info("Scheduled Task: Starting {$this->signature}");

        // 1. Récupérer les réservations pertinentes (statut 'completed', date de fin = hier)
        $endedReservations = Reservation::where('status', 'completed') 
                                    ->whereDate('end_date', '=', $targetDate)
                                    ->with([ 
                                        'client:id,username',
                                        'partner:id,username', 
                                        'listing:id,item_id',
                                        'listing.item:id,title'
                                        ])
                                    ->get();

        if ($endedReservations->isEmpty()) {
            $this->info('No completed reservations found for the target date.');
            Log::info("Scheduled Task: {$this->signature} - No completed reservations found for {$targetDate->toDateString()}.");
            return Command::SUCCESS; 
        }

        $reservationIds = $endedReservations->pluck('id');

        // 2. Récupérer les avis DÉJÀ laissés pour ces réservations (en une seule requête)
        $existingReviews = Review::whereIn('reservation_id', $reservationIds)
                                ->select('reservation_id', 'reviewer_id', 'type') 
                                ->get()
                                ->groupBy('reservation_id');

        // 3. Récupérer les notifications d'avis DÉJÀ envoyées
        $existingNotifications = Notification::whereIn('reservation_id', $reservationIds)
                                        ->whereIn('type', ['review_object', 'review_partner', 'review_client'])
                                        ->select('reservation_id', 'user_id', 'type')
                                        ->get()
                                        ->keyBy(fn($n) => $n->reservation_id . '_' . $n->user_id . '_' . $n->type);


        $notificationsCreatedCount = 0;

        // 4. Boucle sur chaque réservation terminée hier
        foreach ($endedReservations as $reservation) {
            $this->line("Processing Reservation ID: {$reservation->id}");

            $reviewsForThisReservation = $existingReviews->get($reservation->id, collect());

            $clientId = optional($reservation->client)->id;
            $partnerId = optional($reservation->partner)->id;
            $itemTitle = optional(optional($reservation->listing)->item)->title ?? '[Article Supprimé]';
            $clientUsername = optional($reservation->client)->username ?? '[Client Supprimé]';
            $partnerUsername = optional($reservation->partner)->username ?? '[Partenaire Supprimé]';
            $listingId = optional($reservation->listing)->id;

            // Si le client ou le listing n'existe plus, on ne peut pas envoyer de notif fiable
             if (!$clientId || !$partnerId || !$listingId) {
                $this->warn("  -> Skipping Resa ID {$reservation->id}: Missing Client, Partner, or Listing relation.");
                Log::warning("Scheduled Task: Skipped Resa ID {$reservation->id} due to missing relations.");
                continue; 
            }

            // --- Créer Notif CLIENT -> ÉVALUER OBJET ---
            $clientHasReviewedObject = $reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $clientId && $r->type == 'forObject');
            $notifKeyObject = $reservation->id . '_' . $clientId . '_review_object';

            if (!$clientHasReviewedObject && !$existingNotifications->has($notifKeyObject)) {
                Notification::create([
                    'user_id' => $clientId,
                    'message' => "Évaluez l'équipement \"{$itemTitle}\" loué (Résa #{$reservation->id}).",
                    'type' => 'review_object',
                    'listing_id' => $listingId,
                    'reservation_id' => $reservation->id,
                    'is_read' => 0,
                ]);
                $notificationsCreatedCount++;
                 $this->line("  -> Notif 'review_object' créée pour client {$clientId}");
                 Log::debug("Scheduled Task: Created 'review_object' notification for User {$clientId}, Res {$reservation->id}");
            }

             // --- Créer Notif CLIENT -> ÉVALUER PARTENAIRE ---
             $clientHasReviewedPartner = $reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $clientId && $r->type == 'forPartner');
             $notifKeyPartner = $reservation->id . '_' . $clientId . '_review_partner';

             if (!$clientHasReviewedPartner && !$existingNotifications->has($notifKeyPartner)) {
                 Notification::create([
                    'user_id' => $clientId,
                    'message' => "Comment s'est passée votre expérience avec {$partnerUsername} (Résa #{$reservation->id}) ?",
                    'type' => 'review_partner',
                    'listing_id' => $listingId,
                    'reservation_id' => $reservation->id,
                    'is_read' => 0,
                ]);
                 $notificationsCreatedCount++;
                 $this->line("  -> Notif 'review_partner' créée pour client {$clientId}");
                 Log::debug("Scheduled Task: Created 'review_partner' notification for User {$clientId}, Res {$reservation->id}");
             }

            // --- Créer Notif PARTENAIRE -> ÉVALUER CLIENT ---
            $partnerHasReviewedClient = $reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $partnerId && $r->type == 'forClient');
             $notifKeyClient = $reservation->id . '_' . $partnerId . '_review_client';

             if (!$partnerHasReviewedClient && !$existingNotifications->has($notifKeyClient)) {
                Notification::create([
                    'user_id' => $partnerId,
                    'message' => "Évaluez votre expérience avec {$clientUsername} pour la location de \"{$itemTitle}\" (Résa #{$reservation->id}).",
                    'type' => 'review_client',
                    'listing_id' => $listingId,
                    'reservation_id' => $reservation->id,
                    'is_read' => 0,
                ]);
                 $notificationsCreatedCount++;
                 $this->line("  -> Notif 'review_client' créée pour partenaire {$partnerId}");
                 Log::debug("Scheduled Task: Created 'review_client' notification for User {$partnerId}, Res {$reservation->id}");
            }
        }

        $this->info($notificationsCreatedCount . ' nouvelles notifications d\'évaluation créées.');
        Log::info("Scheduled Task: {$this->signature} finished. Created {$notificationsCreatedCount} new notifications.");
        return Command::SUCCESS;
    }
}