<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    // Une catégorie peut avoir plusieurs objets
    public function objets()
    {
        return $this->hasMany(Objet::class);
    }
}