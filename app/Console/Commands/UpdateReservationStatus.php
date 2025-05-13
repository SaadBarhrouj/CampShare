<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateReservationStatus extends Command
{
   
    protected $signature = 'reservations:update-status'; // Nom de la commande


    protected $description = 'Updates reservation statuses to "ongoing" or "completed" based on dates.';

    public function handle()
    {
        $this->info('Starting to update reservation statuses...');
        Log::info("Scheduled Task (Command: {$this->signature}): Starting process.");

        $now = Carbon::now(); 
        $today = $now->toDateString(); 

        $ongoingUpdatedCount = 0;
        $completedUpdatedCount = 0;

        // 1. Mettre à jour les réservations en 'ongoing'
        // Conditions :
        // - Statut actuel est 'confirmed'
        // - start_date est passée ou aujourd'hui
        // - end_date n'est pas encore passée
        try {
            $ongoingUpdatedCount = Reservation::where('status', 'confirmed')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today) 
                ->update([
                    'status' => 'ongoing',
                    'updated_at' => $now 
                ]);

            if ($ongoingUpdatedCount > 0) {
                $this->info("{$ongoingUpdatedCount} reservations updated to 'ongoing'.");
                Log::info("Scheduled Task (Command: {$this->signature}): {$ongoingUpdatedCount} reservations updated to 'ongoing'.");
            }
        } catch (\Exception $e) {
            $this->error("Error updating reservations to 'ongoing': " . $e->getMessage());
            Log::error("Scheduled Task (Command: {$this->signature}): Error updating reservations to 'ongoing'. " . $e->getMessage());
        }


        // 2. Mettre à jour les réservations en 'completed'
        // Conditions :
        // - Statut actuel est 'ongoing' (ou 'confirmed' si la start_date = end_date et que c'est hier)
        // - end_date est passée
        try {
            $completedUpdatedCount = Reservation::whereIn('status', ['ongoing', 'confirmed']) 
                ->where('end_date', '<', $today) 
                ->update([
                    'status' => 'completed',
                    'updated_at' => $now 
                ]);

            if ($completedUpdatedCount > 0) {
                $this->info("{$completedUpdatedCount} reservations updated to 'completed'.");
                Log::info("Scheduled Task (Command: {$this->signature}): {$completedUpdatedCount} reservations updated to 'completed'.");
            }
        } catch (\Exception $e) {
            $this->error("Error updating reservations to 'completed': " . $e->getMessage());
            Log::error("Scheduled Task (Command: {$this->signature}): Error updating reservations to 'completed'. " . $e->getMessage());
        }


        // 3. Résumé final
        if ($ongoingUpdatedCount === 0 && $completedUpdatedCount === 0) {
            $this->info('No reservation statuses needed an update.');
            Log::info("Scheduled Task (Command: {$this->signature}): No reservation statuses needed an update.");
        } else {
            $this->info('Reservation status update process finished.');
            Log::info("Scheduled Task (Command: {$this->signature}): Finished processing.");
        }

        return Command::SUCCESS;
    }
}