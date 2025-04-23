<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start = $this->faker->dateTimeBetween('now', '+1 week');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +1 week');

        return [
            'start_date' => $start,
            'end_date' => $end,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'ongoing', 'canceled', 'completed']),
            'delivery_option' => $this->faker->boolean,
            'client_id' => User::factory(),
            'partner_id' => \App\Models\User::factory(),
            'listing_id' => Listing::factory(),
        ];
    }
}
