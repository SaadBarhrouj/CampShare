<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;    // <--- AJOUTEZ CETTE LIGNE
use App\Models\Annonce; // <--- AJOUTEZ CETTE LIGNE
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // database/factories/ReservationFactory.php
public function definition(): array
{
    $dateDebut = fake()->dateTimeBetween('-1 week', '+1 week');
    $dateFin = fake()->dateTimeBetween($dateDebut, '+2 weeks');

    return [
        'client_id' => User::where('role', 'client')->inRandomOrder()->first()->id,
        'annonce_id' => Annonce::inRandomOrder()->first()->id,
        'date_debut' => $dateDebut,
        'date_fin' => $dateFin,
        'statut' => fake()->randomElement(['confirmée', 'en attente', 'annulée']),
    ];
}
}
