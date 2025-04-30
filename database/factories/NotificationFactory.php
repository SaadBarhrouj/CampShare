<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user = User::inRandomOrder()->first();

        return [
            'user_id' => $user,
            'type' => $this->faker->randomElement(['review_object', 'review_client', 'review_partner', 'updated_listing', 'added_listing']),
            'message' => $this->faker->sentence,
            'is_read' => $this->faker->boolean,
        ];
    }
}
