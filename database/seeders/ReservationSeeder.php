<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;        // <--- AJOUTEZ CETTE LIGNE
use App\Models\Annonce;     // <--- AJOUTEZ CETTE LIGNE
use App\Models\Reservation; // <--- AJOUTEZ CETTE LIGNE

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les clients et les annonces existants
        $clients = User::where('role', 'client')->get(); // Trouvera User
        $annonces = Annonce::all(); // Trouvera Annonce

        // Vérifier s'il y a des clients et des annonces
        if ($clients->isEmpty() || $annonces->isEmpty()) {
            $this->command->info('ReservationSeeder: Skipping because no clients or annonces were found.');
            return;
        }

        // Pour chaque client, créer 2 réservations sur des annonces aléatoires
        foreach ($clients as $client) {
            // S'assurer qu'il y a assez d'annonces pour en choisir 2 différentes si possible
            $annoncesDisponibles = $annonces->random(min(2, $annonces->count())); // Prend 2 annonces au hasard ou moins s'il n'y en a pas assez

            foreach($annoncesDisponibles as $annonce) {
                Reservation::factory()->create([ // Trouvera Reservation
                    'client_id' => $client->id,
                    'annonce_id' => $annonce->id
                ]);
            }
        }
    }
}