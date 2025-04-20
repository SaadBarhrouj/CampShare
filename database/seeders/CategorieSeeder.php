<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie; // <--- AJOUTEZ CETTE LIGNE IMPORTANTE

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void // Assurez-vous d'avoir une seule méthode run bien définie
    {
        $categories = ['Jouet enfant', 'Jouet bébé', 'Équipement sportif', 'Outils'];
        // Renommer la variable dans la boucle est une bonne pratique pour éviter la confusion
        foreach ($categories as $nomCategorie) {
            Categorie::create(['nom' => $nomCategorie]); // PHP trouvera la classe Categorie grâce à la ligne "use"
        }
    }
}