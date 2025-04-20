<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation; // <--- AJOUTER
use App\Models\Reclamation; // <--- AJOUTER

class ReclamationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les réservations existantes pour lier les réclamations
        $reservations = Reservation::all(); // Trouvera Reservation

        if ($reservations->isEmpty()) {
            $this->command->info('ReclamationSeeder: Skipping because no reservations were found.');
            return;
        }

        // Créer une réclamation pour une partie des réservations (ex: 30%)
        foreach ($reservations->random(floor($reservations->count() * 0.3)) as $reservation) { // Prend ~30% des réservations au hasard
            if ($reservation->client_id) { // S'assurer que la réservation a un client_id
                Reclamation::factory()->create([ // Trouvera Reclamation
                    'utilisateur_id' => $reservation->client_id, // L'utilisateur qui fait la réclamation est le client
                    'reservation_id' => $reservation->id
                    // La factory s'occupera du contenu, statut, date
                ]);
            }
        }
    }
}