<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestClientActionMail;
use App\Mail\RequestPartnerToReviewClientMail;

class ReviewNotification extends Command
{
    protected $signature = 'reservations:send-review-notifications';
    protected $description = 'Check for ended reservations and send review notifications and emails if no review exists yet';

    public function handle()
    {
        $targetDate = Carbon::yesterday();
        $this->info("Starting review notification and email check for reservations ended on {$targetDate->toDateString()}...");
        Log::info("Scheduled Task (Command: {$this->signature}): Starting process for reservations ended on {$targetDate->toDateString()}.");

        $endedReservations = Reservation::where('status', 'completed')
                                    ->whereDate('end_date', '=', $targetDate)
                                    ->with([
                                        'client:id,username,email',
                                        'partner:id,username,email',
                                        'listing:id,item_id',
                                        'listing.item:id,title'
                                        ])
                                    ->get();

        if ($endedReservations->isEmpty()) {
            $this->info('No completed reservations found for the target date.');
            Log::info("Scheduled Task (Command: {$this->signature}): No completed reservations found for {$targetDate->toDateString()}.");
            return Command::SUCCESS;
        }

        $reservationIds = $endedReservations->pluck('id');

        $existingReviews = Review::whereIn('reservation_id', $reservationIds)
                                ->select('reservation_id', 'reviewer_id', 'type')
                                ->get()
                                ->groupBy('reservation_id');

        $existingNotifications = Notification::whereIn('reservation_id', $reservationIds)
                                        ->whereIn('type', ['review_object', 'review_partner', 'review_client'])
                                        ->select('reservation_id', 'user_id', 'type')
                                        ->get()
                                        ->keyBy(fn($n) => $n->reservation_id . '_' . $n->user_id . '_' . $n->type);

        $notificationsCreatedCount = 0;
        $emailsSentCount = 0;

        foreach ($endedReservations as $reservation) {
            $this->line("Processing Reservation ID: {$reservation->id}");
            Log::debug("Scheduled Task (Command: {$this->signature}): Processing Reservation ID {$reservation->id}.");

            $reviewsForThisReservation = $existingReviews->get($reservation->id, collect());

            $client = $reservation->client;
            $partner = $reservation->partner;

            if (!$client || !$partner || !$reservation->listing || !$client->email || !$partner->email) {
                $this->warn("  -> Skipping Resa ID {$reservation->id}: Missing Client/Partner (or their email)/Listing relation.");
                Log::warning("Scheduled Task (Command: {$this->signature}): Skipped Resa ID {$reservation->id} due to missing relations or email for notification/email.");
                continue;
            }

            $itemTitle = optional($reservation->listing->item)->title ?? '[Article Supprimé]';
            $clientUsername = $client->username ?? '[Client Supprimé]';
            $partnerUsername = $partner->username ?? '[Partenaire Supprimé]';
            $listingId = $reservation->listing->id;

            $needsClientObjectReview = !$reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $client->id && $r->type == 'forObject');
            $needsClientPartnerReview = !$reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $client->id && $r->type == 'forPartner');

            $notifKeyObject = $reservation->id . '_' . $client->id . '_review_object';
            $notifKeyPartner = $reservation->id . '_' . $client->id . '_review_partner';

            $clientActionRequiredForEmail = false;

            if ($needsClientObjectReview && !$existingNotifications->has($notifKeyObject)) {
                Notification::create([
                    'user_id' => $client->id,
                    'message' => "Évaluez l'équipement \"{$itemTitle}\" loué (Résa #{$reservation->id}).",
                    'type' => 'review_object', 'listing_id' => $listingId, 'reservation_id' => $reservation->id, 'is_read' => 0,
                ]);
                $notificationsCreatedCount++;
                $this->line("  -> Notif (interne) 'review_object' créée pour client {$client->id}");
                Log::debug("Scheduled Task (Command: {$this->signature}): Created 'review_object' internal notification for User {$client->id}, Res {$reservation->id}");
                $clientActionRequiredForEmail = true;
            }

            if ($needsClientPartnerReview && !$existingNotifications->has($notifKeyPartner)) {
                Notification::create([
                    'user_id' => $client->id,
                    'message' => "Comment s'est passée votre expérience avec {$partnerUsername} (Résa #{$reservation->id}) ?",
                    'type' => 'review_partner', 'listing_id' => $listingId, 'reservation_id' => $reservation->id, 'is_read' => 0,
                ]);
                $notificationsCreatedCount++;
                $this->line("  -> Notif (interne) 'review_partner' créée pour client {$client->id}");
                Log::debug("Scheduled Task (Command: {$this->signature}): Created 'review_partner' internal notification for User {$client->id}, Res {$reservation->id}");
                $clientActionRequiredForEmail = true;
            }

            if ($clientActionRequiredForEmail) {
                try {
                    Mail::to($client->email)->send(new RequestClientActionMail($reservation, $client, $itemTitle, $partnerUsername, $needsClientObjectReview, $needsClientPartnerReview));
                    $this->line("    -> Email 'RequestClientActionMail' envoyé à client {$client->id} ({$client->email})");
                    Log::info("Scheduled Task (Command: {$this->signature}): Sent 'RequestClientActionMail' to User {$client->id}, Res {$reservation->id}");
                    $emailsSentCount++;
                } catch (\Exception $e) {
                    $this->error("    -> Erreur envoi email 'RequestClientActionMail' à client {$client->id}: " . $e->getMessage());
                    Log::error("Scheduled Task (Command: {$this->signature}): Failed to send 'RequestClientActionMail' for User {$client->id}, Res {$reservation->id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                }
            }

            $needsPartnerClientReview = !$reviewsForThisReservation->contains(fn($r) => $r->reviewer_id == $partner->id && $r->type == 'forClient');
            $notifKeyClient = $reservation->id . '_' . $partner->id . '_review_client';

            if ($needsPartnerClientReview && !$existingNotifications->has($notifKeyClient)) {
                Notification::create([
                    'user_id' => $partner->id,
                    'message' => "Évaluez votre expérience avec {$clientUsername} pour la location de \"{$itemTitle}\" (Résa #{$reservation->id}).",
                    'type' => 'review_client', 'listing_id' => $listingId, 'reservation_id' => $reservation->id, 'is_read' => 0,
                ]);
                $notificationsCreatedCount++;
                $this->line("  -> Notif (interne) 'review_client' créée pour partenaire {$partner->id}");
                Log::debug("Scheduled Task (Command: {$this->signature}): Created 'review_client' internal notification for User {$partner->id}, Res {$reservation->id}");

                try {
                    Mail::to($partner->email)->send(new RequestPartnerToReviewClientMail($reservation, $partner, $clientUsername, $itemTitle));
                    $this->line("    -> Email 'RequestPartnerToReviewClientMail' envoyé à partenaire {$partner->id} ({$partner->email})");
                    Log::info("Scheduled Task (Command: {$this->signature}): Sent 'RequestPartnerToReviewClientMail' to User {$partner->id}, Res {$reservation->id}");
                    $emailsSentCount++;
                } catch (\Exception $e) {
                    $this->error("    -> Erreur envoi email 'RequestPartnerToReviewClientMail' à partenaire {$partner->id}: " . $e->getMessage());
                    Log::error("Scheduled Task (Command: {$this->signature}): Failed to send 'RequestPartnerToReviewClientMail' for User {$partner->id}, Res {$reservation->id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                }
            }
        }

        $this->info($notificationsCreatedCount . ' nouvelles notifications d\'évaluation (internes) créées.');
        $this->info($emailsSentCount . ' e-mails d\'évaluation envoyés (ou tentés).');
        Log::info("Scheduled Task (Command: {$this->signature}): Finished. Created {$notificationsCreatedCount} new internal notifications. Attempted to send {$emailsSentCount} emails.");
        return Command::SUCCESS;
    }
}