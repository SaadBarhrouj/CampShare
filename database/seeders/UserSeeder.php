<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Ligne optionnelle
use Illuminate\Database\Seeder;
use App\Models\User; // <--- CETTE LIGNE EST MANQUANTE DANS VOTRE FICHIER !

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void // Assurez-vous que la méthode run est bien définie UNE SEULE FOIS comme ceci
    {
        // Créer 1 admin
        User::factory()->create([ // PHP sait maintenant ce qu'est "User" grâce à la ligne "use"
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        // Créer 5 propriétaires
        User::factory(5)->create(['role' => 'proprietaire']);

        // Créer 15 clients
        User::factory(15)->create(['role' => 'client']);
    }
}