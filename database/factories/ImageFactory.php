<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objet; 
use App\Models\Image; 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // database/factories/ImageFactory.php
public function definition(): array
{
    return [
        'url' => 'images/' . fake()->uuid() . '.jpg', // Chemin fictif
        'objet_id' => Objet::inRandomOrder()->first()->id,
    ];
}
}
