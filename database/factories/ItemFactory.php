<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Object>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $category = Category::inRandomOrder()->first();
        $partner = User::where('role', 'partner')->inRandomOrder()->first();

        return [
            'partner_id' => $partner,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(2, true),
            'price_per_day' => $this->faker->randomFloat(2, 10, 1000),
            'category_id' => $category,
        ];
    }
}
