<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // or use Hash::make()
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'role' => $this->faker->randomElement(['client', 'partner', 'admin']),
            'avatar_url' => $this->faker->imageUrl(),
            'cin_recto' => $this->faker->imageUrl(),
            'cin_verso' => $this->faker->imageUrl(),
            'avg_rating' => $this->faker->randomFloat(1, 1, 5),
            'review_count' => $this->faker->numberBetween(0, 100),
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'city_id' => City::factory(),
        ];
    }
}
