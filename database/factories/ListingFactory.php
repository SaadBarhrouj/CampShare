<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $item = Item::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();

        $isPremium = $this->faker->boolean(30); 
        $premiumStartDate = $isPremium ? fake()->date() : null;
        $premiumType = $isPremium ? $this->faker->randomElement(['7 jours', '15 jours', '30 jours']) : null;

        $cityCoordinates = [
            'Casablanca' => [
                'latitude' => [33.53, 33.60],
                'longitude' => [-7.65, -7.55]
            ],
            'Rabat' => [
                'latitude' => [33.95, 34.05],
                'longitude' => [-6.85, -6.75]
            ],
            'Marrakech' => [
                'latitude' => [31.60, 31.65],
                'longitude' => [-8.05, -7.95]
            ],
            'Fès' => [
                'latitude' => [34.00, 34.05],
                'longitude' => [-5.00, -4.95]
            ],
            'Tanger' => [
                'latitude' => [35.75, 35.80],
                'longitude' => [-5.85, -5.75]
            ],
            'Tétouan' => [
                'latitude' => [35.55, 35.60],
                'longitude' => [-5.40, -5.30]
            ],
            'Agadir' => [
                'latitude' => [30.40, 30.45],
                'longitude' => [-9.65, -9.55]
            ],
            'Meknès' => [
                'latitude' => [33.85, 33.90],
                'longitude' => [-5.60, -5.50]
            ],
            'Oujda' => [
                'latitude' => [34.65, 34.70],
                'longitude' => [-1.95, -1.85]
            ],
            'Kénitra' => [
                'latitude' => [34.25, 34.30],
                'longitude' => [-6.60, -6.50]
            ],
            'El Jadida' => [
                'latitude' => [33.20, 33.25],
                'longitude' => [-8.55, -8.45]
            ],
            'Safi' => [
                'latitude' => [32.28, 32.33],
                'longitude' => [-9.25, -9.15]
            ],
            'Nador' => [
                'latitude' => [35.15, 35.20],
                'longitude' => [-2.95, -2.85]
            ],
            'Taza' => [
                'latitude' => [34.20, 34.25],
                'longitude' => [-4.00, -3.90]
            ],
            'Larache' => [
                'latitude' => [35.18, 35.23],
                'longitude' => [-6.15, -6.05]
            ],
            'Al Hoceïma' => [
                'latitude' => [35.23, 35.28],
                'longitude' => [-3.95, -3.85]
            ],
            'Berrechid' => [
                'latitude' => [33.25, 33.30],
                'longitude' => [-7.60, -7.50]
            ],
        ];

        $cityName = $city->name;
        $coordinates = $cityCoordinates[$cityName] ?? $cityCoordinates['Casablanca']; // default casablanca

        return [
            'item_id' => $item, 
            'status' => $this->faker->randomElement(['active', 'archived']), 
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'city_id' => $city,
            'latitude' => $this->faker->latitude($coordinates['latitude'][0], $coordinates['latitude'][1]),
            'longitude' => $this->faker->longitude($coordinates['longitude'][0], $coordinates['longitude'][1]),
            'delivery_option' => $this->faker->boolean(70),
            'is_premium' => $isPremium,
            'premium_type' => $premiumType, 
            'premium_start_date' => $premiumStartDate,
            
        ];
    }
}
