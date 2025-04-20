<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;       // <--- AJOUTEZ CETTE LIGNE
use App\Models\Categorie;   // <--- AJOUTEZ CETTE LIGNE
use App\Models\Objet;       // <--- AJOUTEZ CETTE LIGNE

class ObjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void // Assurez-vous d'avoir une seule méthode run
    {
        // PHP trouvera User, Categorie et Objet grâce aux lignes "use" ci-dessus
        $proprietaires = User::where('role', 'proprietaire')->get();
        $categories = Categorie::all();

        // C'est une bonne idée de vérifier si des propriétaires et catégories existent
        if ($proprietaires->isEmpty() || $categories->isEmpty()) {
             $this->command->warn('ObjetSeeder: Skipping because no users with role "proprietaire" or no categories were found.');
             return; // Ne rien faire si les prérequis ne sont pas là
        }

        foreach ($proprietaires as $proprietaire) {
            Objet::factory(3)->create([
                'proprietaire_id' => $proprietaire->id,
                'categorie_id' => $categories->random()->id // Prend un ID de catégorie au hasard parmi celles existantes
            ]);
        }
    }
}