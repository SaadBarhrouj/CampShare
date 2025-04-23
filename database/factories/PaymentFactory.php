<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $listing = Listing::inRandomOrder()->first();
        $partner = User::where('role', 'partner')->inRandomOrder()->first();


        return [
            'partner_id' => $partner,
            'amount' => $this->faker->randomFloat(2, 20, 5000),
            'payment_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'listing_id' => $listing,
        ];
    }
}
