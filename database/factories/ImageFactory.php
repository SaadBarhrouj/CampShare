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
                'images/item-6.jpg',
                'images/item-5.jpg',
                'images/item-4.jpg',
                'images/item-3.jpg',
                'images/item-2.jpg',
                'images/item-1.jpg',
                ])
            ->random(),

        ];
    }
}
