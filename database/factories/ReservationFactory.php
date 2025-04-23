<?php

namespace Database\Factories;

use Carbon\Carbon;
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

        $start = Carbon::parse($this->faker->dateTimeBetween('now', '+1 week'));
        $end = Carbon::parse($this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +1 week'));
        
        $partner = User::where('role', 'partner')->inRandomOrder()->first();
        $client = User::where('role', 'client')->inRandomOrder()->first();

        $listing = Listing::inRandomOrder()->first();

        return [
            'start_date' => $start,
            'end_date' => $end,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'ongoing', 'canceled', 'completed']),
            'delivery_option' => $this->faker->boolean,
            'client_id' => $client,
            'partner_id' => $partner,
            'listing_id' => $listing,
        ];
    }
}
