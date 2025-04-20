<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categorie;
use App\Models\User;  

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Objet>
 */
class ObjetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array // Assurez-vous d'avoir une seule méthode definition
    {
        // Récupérer un propriétaire et une catégorie existants
        $proprietaire = User::where('role', 'proprietaire')->inRandomOrder()->first();
        $categorie = Categorie::inRandomOrder()->first();

        // Gérer le cas où rien n'est trouvé (important pour éviter les erreurs "Attempt to read property 'id' on null")
        if (!$proprietaire) {
            throw new \Exception('ObjetFactory: No user with role "proprietaire" found. Please run UserSeeder first.');
        }
        if (!$categorie) {
             throw new \Exception('ObjetFactory: No categories found. Please run CategorieSeeder first.');
        }

        return [
            'nom' => fake()->words(2, true),
            'description' => fake()->paragraph(),
            'ville' => fake()->city(),
            'prix_journalier' => fake()->randomFloat(2, 10, 500),
            'etat' => fake()->randomElement(['neuf', 'occasion', 'endommagé']),
            'categorie_id' => $categorie->id, // Utilise l'ID de la catégorie trouvée
            'proprietaire_id' => $proprietaire->id, // Utilise l'ID du propriétaire trouvé
        ];
    }
}