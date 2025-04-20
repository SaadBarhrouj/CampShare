<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu', 'statut', 'date_creation', 'utilisateur_id', 'reservation_id'
    ];

    // Une réclamation appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Une réclamation est liée à une réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}