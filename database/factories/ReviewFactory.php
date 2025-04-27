<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Item;
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
        $item = Item::inRandomOrder()->first();
        $reviewer = User::inRandomOrder()->first();
        $reviewee = User::inRandomOrder()->first();
        $reservation = Reservation::inRandomOrder()->first();

        return [
            'reservation_id' => $reservation,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentences(2, true),
            'is_visible' => $this->faker->boolean,
            'type' => $this->faker->randomElement(['forObject', 'forClient', 'forPartner']),
            'reviewer_id' => $reviewer,
            'reviewee_id' => $reviewee,
            'item_id' => $item,
        ];
    }
}
