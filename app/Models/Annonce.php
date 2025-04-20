<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_publication', 'date_debut', 'date_fin', 'statut', 'premium', 'adresse', 'objet_id', 'proprietaire_id'
    ];

    // Une annonce appartient à un objet
    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    // Une annonce appartient à un propriétaire (User)
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }
}