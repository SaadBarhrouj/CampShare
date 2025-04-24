<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $listing = Listing::inRandomOrder()->first();
        
        return [
            'listing_id' => $listing,
            'url' => collect([
    'http://127.0.0.1:8000/images/1.jpg',
    'http://127.0.0.1:8000/images/2.jpg',
    'http://127.0.0.1:8000/images/listing-1.jpg',
])->random(),

        ];
    }
}
