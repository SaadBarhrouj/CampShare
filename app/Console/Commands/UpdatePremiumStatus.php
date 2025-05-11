<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdatePremiumStatus extends Command
{

    protected $signature = 'listings:update-premium-status'; 


    protected $description = 'Checks for listings with expired premium status and reverts them to non-premium';


    public function handle()
    {
        $this->info('Starting to check and update expired premium listings...');
        Log::info('Cron Job: UpdatePremiumStatus - Démarrage');

        $today = Carbon::now()->toDateString();
        $totalUpdatedCount = 0;

        $premiumTypesAndDurations = [
            '7 jours' => 7,
            '15 jours' => 15,
            '30 jours' => 30,
        ];

        foreach ($premiumTypesAndDurations as $type => $days) {
            $listingIdsToUpdate = Listing::where('is_premium', true)
                ->where('premium_type', $type)
                ->whereNotNull('premium_start_date')
                ->whereRaw('DATE_ADD(premium_start_date, INTERVAL ? DAY) < ?', [$days, $today])
                ->pluck('id');

            if ($listingIdsToUpdate->isNotEmpty()) {
                $updatedCountForType = Listing::whereIn('id', $listingIdsToUpdate)
                    ->update([
                        'is_premium' => false,
                        'premium_type' => null,
                        'premium_start_date' => null,
                        'updated_at' => Carbon::now()
                    ]);

                if ($updatedCountForType > 0) {
                    $this->info("{$updatedCountForType} listings avec premium '{$type}' (expiré avant {$today}) ont été mis à jour.");
                    Log::info("Cron Job: {$updatedCountForType} listings premium '{$type}' expirés (IDs: " . $listingIdsToUpdate->implode(', ') . ") ont été mis à jour.");
                    $totalUpdatedCount += $updatedCountForType;
                }
            }
        }

        if ($totalUpdatedCount > 0) {
            $this->info("Total: {$totalUpdatedCount} premium listings updated to non-premium.");
            Log::info("Cron Job: UpdatePremiumStatus - Terminé. Total {$totalUpdatedCount} annonces mises à jour.");
        } else {
            $this->info('No premium listings found to be expired and updated.');
            Log::info('Cron Job: UpdatePremiumStatus - Terminé. Aucune annonce premium expirée trouvée à mettre à jour.');
        }

        return Command::SUCCESS;
    }
}