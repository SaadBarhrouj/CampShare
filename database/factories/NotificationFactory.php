<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;        // <--- AJOUTER
use App\Models\Annonce;     // <--- AJOUTER
use App\Models\Reservation; // <--- AJOUTER

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupérer des IDs aléatoires, gérer le cas où ils n'existent pas
        $user = User::inRandomOrder()->first();
        $annonce = Annonce::inRandomOrder()->first();
        $reservation = Reservation::inRandomOrder()->first();

        if (!$user) {
             // Si aucun utilisateur n'existe, on ne peut pas créer de notification
             throw new \Exception('NotificationFactory: No users found. Cannot create notification.');
        }

        return [
            'contenu' => fake()->sentence(),
            'contenu_email' => fake()->paragraph(), // Optionnel, peut-être pas toujours nécessaire
            'envoyee' => fake()->boolean(80), // 80% de chance d'être envoyée
            'lue' => fake()->boolean(30), // 30% de chance d'être lue
            'utilisateur_id' => $user->id, // ID de l'utilisateur trouvé
            // Lier aléatoirement à une annonce OU une réservation (pas les deux)
            // `optional()` est pratique ici
            'annonce_id' => fake()->boolean(50) ? ($annonce ? $annonce->id : null) : null, // 50% chance d'être liée à une annonce existante
            'reservation_id' => fake()->boolean(50) ? ($reservation ? $reservation->id : null) : null, // 50% chance d'être liée à une réservation existante
        ];
    }
}