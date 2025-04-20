<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;        // <--- AJOUTER
use App\Models\Reservation; // <--- AJOUTER

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reclamation>
 */
class ReclamationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Les IDs utilisateur_id et reservation_id devraient idéalement
        // être passés par le Seeder pour être cohérents.
        // Si on génère aléatoirement :
        $reservation = Reservation::inRandomOrder()->first();

        if (!$reservation || !$reservation->client_id) {
             // Si aucune réservation valide n'est trouvée, retourner des valeurs par défaut ou lancer une erreur
              return [
                 'contenu' => 'Factory error: Missing valid reservation.',
                 'statut' => 'fermée',
                 'date_creation' => now(),
                 'utilisateur_id' => null, // Impossible de déterminer sans réservation
                 'reservation_id' => null,
             ];
        }

        return [
            'contenu' => fake()->paragraph(2), // 2 phrases pour le contenu
            'statut' => fake()->randomElement(['ouverte', 'en cours', 'résolue', 'rejetée']),
            // La date de création doit être après la date de la réservation
            'date_creation' => fake()->dateTimeBetween($reservation->created_at ?? '-1 month', 'now'),
            'utilisateur_id' => $reservation->client_id, // Utilise le client de la réservation trouvée
            'reservation_id' => $reservation->id, // Utilise l'ID de la réservation trouvée
        ];
    }
}