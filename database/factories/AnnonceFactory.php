<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objet; 
use App\Models\User; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebut = fake()->dateTimeBetween('-1 month', '+1 month');
        $dateFin = fake()->dateTimeBetween($dateDebut, '+3 months');

        // Récupérer un objet et un propriétaire existants
        $objet = Objet::inRandomOrder()->first();
        $proprietaire = User::where('role', 'proprietaire')->inRandomOrder()->first();

        // Gérer les cas où rien n'est trouvé
        if (!$objet) {
            throw new \Exception('AnnonceFactory: No objets found. Please run ObjetSeeder first.');
        }
        if (!$proprietaire) {
            throw new \Exception('AnnonceFactory: No user with role "proprietaire" found. Please run UserSeeder first.');
        }

        return [
            'date_publication' => now(),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'statut' => fake()->randomElement(['active', 'inactive', 'terminee']), 
            'premium' => fake()->boolean(10), 
            'adresse' => fake()->address(),
            'objet_id' => $objet->id, 
            'proprietaire_id' => $proprietaire->id, 
        ];
    }
}