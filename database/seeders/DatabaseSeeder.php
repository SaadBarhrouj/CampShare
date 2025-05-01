<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\CitySeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\ListingSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ReservationSeeder;
use Database\Seeders\NotificationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            ListingSeeder::class,
            ImageSeeder::class,
            ReservationSeeder::class,
            ReviewSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
