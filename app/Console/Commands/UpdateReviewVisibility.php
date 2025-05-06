<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review; 
use App\Services\ReviewVisibilityService; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateReviewVisibility extends Command
{
    /**
     * La signature de la commande console.
     * Utilisée pour appeler la commande : php artisan reviews:update-visibility-after-delay
     *
     * @var string
     */
    protected $signature = 'reviews:update-visibility-after-delay';

    /**
     * La description de la commande console.
     * Affichée quand on tape : php artisan list
     *
     * @var string
     */
    protected $description = 'Rend visibles les avis client/partenaire si le délai de 7 jours est passé et qu\'ils sont encore cachés.';

    /**
     * Le service qui contient la logique de mise à jour de la visibilité.
     */
    protected ReviewVisibilityService $reviewVisibilityService;


    public function __construct(ReviewVisibilityService $reviewVisibilityService)
    {
        parent::__construct();
        $this->reviewVisibilityService = $reviewVisibilityService;
    }


    public function handle()
    {
        $this->info('Démarrage de la mise à jour de visibilité des avis après délai...');
        Log::info("Tâche Planifiée : Démarrage de {$this->signature}");

        // 1. Déterminer la date limite (il y a 7 jours)
        $cutoffDate = Carbon::now()->subDays(ReviewVisibilityService::VISIBILITY_DELAY_DAYS)->endOfDay();
        $this->line("Date limite (end_date <=) : " . $cutoffDate->format('Y-m-d H:i:s'));

        // 2. Trouver les avis pertinents :
        //    - Type 'forClient' ou 'forPartner'
        //    - Actuellement NON visibles (is_visible = false)
        //    - Dont la réservation associée est 'completed' ET s'est terminée AVANT ou À la date limite.
        $reviewsToMakeVisible = Review::where('is_visible', false)
            ->whereIn('type', ['forClient', 'forPartner'])
            ->whereHas('reservation', function ($query) use ($cutoffDate) {
                $query->where('status', 'completed')
                      ->where('end_date', '<=', $cutoffDate); 
            })
            ->with('reservation:id,end_date')
            ->get();

        $count = 0; 

        // 3. Traiter les avis trouvés
        if ($reviewsToMakeVisible->isNotEmpty()) {
            $this->line("Trouvé {$reviewsToMakeVisible->count()} avis client/partenaire à rendre visibles après délai.");

            foreach ($reviewsToMakeVisible as $review) {
                $this->line(" -> Traitement de l'avis ID: {$review->id} (Résa ID: {$review->reservation_id}, Type: {$review->type})");
                if ($this->reviewVisibilityService->makeReviewVisible($review)) {
                    $count++;
                } else {
                     $this->line("   (Avis ID: {$review->id} était déjà visible ou erreur lors de la mise à jour - voir logs du service)");
                }
            }
        } else {
             $this->line("Aucun avis client/partenaire caché trouvé après la période de délai.");
        }

        // 4. Afficher le résumé et terminer
        $this->info("Mise à jour de la visibilité terminée pour {$count} avis après délai.");
        Log::info("Tâche Planifiée : Fin de {$this->signature}. Visibilité mise à jour pour {$count} avis.");
        return Command::SUCCESS; 
    }
}