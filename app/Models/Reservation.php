<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'annonce_id', 'date_debut', 'date_fin', 'statut'
    ];

    // Une réservation appartient à un client (User)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Une réservation appartient à une annonce
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}