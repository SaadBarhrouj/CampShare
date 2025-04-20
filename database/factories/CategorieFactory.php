<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // database/factories/CategorieFactory.php
public function definition(): array
{
    return [
        'nom' => fake()->unique()->word(), // Catégories uniques
    ];
}
}
