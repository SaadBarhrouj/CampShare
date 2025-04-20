<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // <--- N'oubliez pas d'importer User si ce n'est pas déjà fait
use App\Models\Categorie; // <-- Importer Categorie aussi
use App\Models\Image; // <-- Importer Image
use App\Models\Annonce; // <-- Importer Annonce

class Objet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'ville', 'prix_journalier', 'etat', 'categorie_id', 'proprietaire_id'
    ];

    // Un objet appartient à une catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Un objet a plusieurs images
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // Un objet a une annonce associée
    public function annonce()
    {
        return $this->hasOne(Annonce::class);
    }

    // === MÉTHODE MANQUANTE À AJOUTER ===
    // Un objet appartient à un propriétaire (User)
    public function proprietaire()
    {
        // Le deuxième argument 'proprietaire_id' est la clé étrangère dans la table 'objets'
        // qui référence la table 'users'.
        return $this->belongsTo(User::class, 'proprietaire_id');
    }
    // ===================================
}