<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start = Carbon::parse($this->faker->dateTimeBetween('-1 month', 'now'));
        $end = Carbon::parse($this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +1 month'));

        $city = City::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $partner = User::where('role', 'partner')->inRandomOrder()->first();

        return [
            'partner_id' => $partner,
            'city_id' => $city,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(2, true),
            'price_per_day' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['active', 'archived', 'inactive']),
            'is_premium' => $this->faker->boolean,
            'premium_start_date' => $start,
            'premium_end_date' => $end,
            'category_id' => $category,
            'delivery_option' => $this->faker->boolean,
        ];
    }
}
