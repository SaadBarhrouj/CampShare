<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $moroccanCities = [
            'Casablanca',
            'Rabat',
            'Marrakech',
            'Fès',
            'Tanger',
            'Agadir',
            'Meknès',
            'Oujda',
            'Kénitra',
            'Tétouan',
            'Safi',
            'Mohammédia',
            'El Jadida',
            'Béni Mellal',
            'Nador',
            'Taza',
            'Khémisset',
            'Larache',
            'Ksar El Kebir',
            'Guelmim',
            'Berrechid',
            'Errachidia',
            'Taroudant',
            'Settat',
            'Al Hoceïma'
        ];
        
        return [
            'name' => $this->faker->unique()->randomElement($moroccanCities),
        ];
    }
}
