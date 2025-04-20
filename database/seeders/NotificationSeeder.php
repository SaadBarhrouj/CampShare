<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;         // <--- AJOUTER
use App\Models\Notification; // <--- AJOUTER

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); // Trouvera User

        if ($users->isEmpty()) {
            $this->command->info('NotificationSeeder: Skipping because no users were found.');
            return;
        }

        // Créer 3 notifications aléatoires pour chaque utilisateur
        foreach ($users as $user) {
            Notification::factory(3)->create([ // Trouvera Notification
                'utilisateur_id' => $user->id
                // La factory s'occupera de lier aléatoirement à annonce/reservation
            ]);
        }
    }
}