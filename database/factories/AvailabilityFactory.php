<?php

namespace Database\Factories;

use Carbon\Carbon;
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

        //$start = Carbon::parse($this->faker->dateTimeBetween('now', '+1 month'));
        //$end = Carbon::parse($this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 weeks'));

        $start = fake()->date();
        $end = fake()->date();

        $listing = Listing::inRandomOrder()->first();

        return [
            'listing_id' => $listing,
            'start_date' => $start,
            'end_date' => $end,
        ];
    }
}
