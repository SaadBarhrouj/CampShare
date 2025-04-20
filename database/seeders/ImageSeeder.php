<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Ligne optionnelle
use Illuminate\Database\Seeder;
use App\Models\Objet; // <-- Ligne nécessaire pour Objet::all()
use App\Models\Image; // <-- Ligne nécessaire pour Image::factory()

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les objets existants
        $objets = Objet::all();

        // Vérifier s'il y a des objets
        if ($objets->isEmpty()) {
            $this->command->info('ImageSeeder: Skipping because no objets were found.');
            return;
        }

        // Pour chaque objet, créer 2 images associées
        foreach ($objets as $objet) {
            // Utiliser la factory Image pour créer 2 images pour cet objet
            Image::factory(2)->create(['objet_id' => $objet->id]);
        }
    }
}