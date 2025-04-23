<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\CitySeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\ListingSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ReservationSeeder;
use Database\Seeders\AvailabilitySeeder;
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
            ListingSeeder::class,
            ImageSeeder::class,
            AvailabilitySeeder::class,
            PaymentSeeder::class,
            ReservationSeeder::class,
            ReviewSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
