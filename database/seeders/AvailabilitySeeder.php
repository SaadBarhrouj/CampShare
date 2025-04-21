<?php

namespace Database\Seeders;

use App\Models\Availability;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Availability::factory()->count(20)->create();
    }
}
