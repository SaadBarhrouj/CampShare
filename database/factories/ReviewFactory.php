<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
            'is_visible' => $this->faker->boolean,
            'type' => $this->faker->randomElement(['forObject', 'forClient', 'forPartner']),
            'reviewer_id' => User::factory(),
            'reviewee_id' => \App\Models\User::factory(),
            'listing_id' => Listing::factory(),
        ];
    }
}
