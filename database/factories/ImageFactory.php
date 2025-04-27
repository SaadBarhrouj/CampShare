<?php

namespace Database\Factories;

use App\Models\Item;
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

        $item = Item::inRandomOrder()->first();
        
        return [
            'item_id' => $item,
            'url' => collect([
                'http://127.0.0.1:8000/images/object-3.jpg',
                'http://127.0.0.1:8000/images/object-2.jpg',
                'http://127.0.0.1:8000/images/object-1.jpg',
                ])
            ->random(),

        ];
    }
}
