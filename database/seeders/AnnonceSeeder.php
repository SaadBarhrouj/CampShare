<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Objet;   // <--- AJOUTEZ CETTE LIGNE
use App\Models\Annonce; // <--- AJOUTEZ CETTE LIGNE

class AnnonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les objets existants
        $objets = Objet::all(); // Trouvera Objet grâce à la ligne "use"

        // Vérifier s'il y a des objets
        if ($objets->isEmpty()) {
            $this->command->info('AnnonceSeeder: Skipping because no objets were found.');
            return;
        }

        // Pour chaque objet, créer une annonce associée en utilisant la factory
        foreach ($objets as $objet) {
            Annonce::factory()->create([ // Trouvera Annonce grâce à la ligne "use"
                'objet_id' => $objet->id,
                'proprietaire_id' => $objet->proprietaire_id // Assure que l'annonce appartient au même propriétaire que l'objet
            ]);
        }
    }
}