<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu', 'contenu_email', 'envoyee', 'lue', 'utilisateur_id', 'annonce_id', 'reservation_id'
    ];

    // Une notification appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}