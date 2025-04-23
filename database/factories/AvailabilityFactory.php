<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start = $this->faker->dateTimeBetween('now', '+1 month');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 weeks');

        return [
            'listing_id' => Listing::factory(),
            'start_date' => $start,
            'end_date' => $end,
        ];
    }
}
