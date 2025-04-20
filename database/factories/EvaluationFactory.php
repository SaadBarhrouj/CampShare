<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objet; // <--- AJOUTER
use App\Models\User;  // <--- AJOUTER

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // On ne peut pas déterminer les bons IDs ici sans contexte,
        // il est préférable de les passer depuis le Seeder.
        // Mais si on veut générer aléatoirement (moins réaliste):
        $objet = Objet::inRandomOrder()->first();
        // S'assurer que l'évaluateur et l'évalué sont différents
        $evaluateur = User::inRandomOrder()->first();
        $evalue = User::where('id', '!=', $evaluateur ? $evaluateur->id : 0)->inRandomOrder()->first();

        // Gérer si les modèles ne sont pas trouvés
        if (!$objet || !$evaluateur || !$evalue) {
             // Retourner des valeurs vides ou lancer une exception si vous préférez
             // Cela peut arriver si les tables sont vides
             return [
                 'note' => 0,
                 'commentaire' => 'Factory error: Missing related model.',
                 'date' => now(),
                 'objet_id' => null,
                 'evaluateur_id' => null,
                 'evalue_id' => null,
             ];
        }

        return [
            'note' => fake()->numberBetween(1, 5),
            'commentaire' => fake()->sentence(), // Utiliser sentence() pour un commentaire plus court
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'objet_id' => $objet->id,
            'evaluateur_id' => $evaluateur->id,
            'evalue_id' => $evalue->id,
        ];
    }
}