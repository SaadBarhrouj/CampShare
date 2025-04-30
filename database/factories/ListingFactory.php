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

        return [
            'item_id' => $item, 
            'status' => $this->faker->randomElement(['active', 'archived']), 
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'city_id' => $city,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'delivery_option' => $this->faker->boolean,
            'is_premium' => $this->faker->boolean,
            'premium_type' => $this->faker->randomElement(['7 jours', '15 jours', '30 jours']), 
            'premium_start_date' => fake()->date(),
            
        ];
    }
}
