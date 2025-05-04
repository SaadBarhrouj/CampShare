<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $categories = [
            'Tentes et Abris',
            'Sacs de couchage',
            'Équipement de cuisine',
            'Mobilier camping',
            'Éclairage',
            'Accessoires outdoor'
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }

}
