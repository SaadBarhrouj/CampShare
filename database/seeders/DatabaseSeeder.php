<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorieSeeder::class,
            ObjetSeeder::class,
            ImageSeeder::class,
            AnnonceSeeder::class,
            ReservationSeeder::class,
            EvaluationSeeder::class,
            NotificationSeeder::class,
            ReclamationSeeder::class
        ]);
    }
}


