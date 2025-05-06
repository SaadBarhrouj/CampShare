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

        $city = City::inRandomOrder()->first();

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), 
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'role' => $this->faker->randomElement(['client', 'partner', 'admin']),
            'avatar_url' => 'images/avatar-default.jpg',
            'cin_recto' => 'images/cin-recto.jpg',
            'cin_verso' => 'images/cin-verso.jpg',
            'is_subscriber' => $this->faker->boolean,
            'is_active' => $this->faker->numberBetween(1, 100) <= 90,
            'city_id' => $city,
        ];
    }
}
