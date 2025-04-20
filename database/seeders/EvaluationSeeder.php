<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;       // <--- AJOUTER
use App\Models\Objet;      // <--- AJOUTER
use App\Models\Evaluation; // <--- AJOUTER
use App\Models\Reservation; // <-- Utile pour une logique plus réaliste

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Logique plus réaliste : Baser les évaluations sur les réservations terminées
        $reservations = Reservation::where('statut', 'confirmée') // ou un statut 'terminée' si vous en avez
                            ->where('date_fin', '<', now()) // Réservations passées
                            ->with(['client', 'annonce.objet.proprietaire']) // Charger les relations
                            ->get();

        if ($reservations->isEmpty()) {
            $this->command->info('EvaluationSeeder: Skipping because no completed reservations were found.');
            return;
        }

        foreach ($reservations as $reservation) {
            $client = $reservation->client;
            $proprietaire = $reservation->annonce->objet->proprietaire ?? null;
            $objet = $reservation->annonce->objet ?? null;

            if ($client && $proprietaire && $objet) {
                // Évaluation du client par le propriétaire
                Evaluation::factory()->create([
                    'evaluateur_id' => $proprietaire->id,
                    'evalue_id' => $client->id,
                    'objet_id' => $objet->id,
                    // Ajouter ici note, commentaire, etc. si nécessaire
                ]);

                // Évaluation du propriétaire (et/ou de l'objet) par le client
                Evaluation::factory()->create([
                    'evaluateur_id' => $client->id,
                    'evalue_id' => $proprietaire->id,
                    'objet_id' => $objet->id,
                     // Ajouter ici note, commentaire, etc. si nécessaire
                ]);
            }
        }

        // Note : L'ancienne logique créait des évaluations un peu au hasard.
        // La nouvelle logique ci-dessus est plus liée au processus réel.
        // Si vous préférez l'ancienne logique (plus simple mais moins réaliste) :
        /*
        $users = User::all();
        $objets = Objet::all();
        if ($users->count() < 2 || $objets->isEmpty()) {
             $this->command->info('EvaluationSeeder: Skipping (old logic) - Not enough users or objets.');
             return;
        }
        foreach ($users as $user) {
             $evalue = User::where('id', '!=', $user->id)->inRandomOrder()->first();
             $objet = $objets->random();
             if ($evalue && $objet) {
                 Evaluation::factory()->create([
                    'evaluateur_id' => $user->id,
                    'evalue_id' => $evalue->id,
                    'objet_id' => $objet->id
                 ]);
             }
        }
        */
    }
}