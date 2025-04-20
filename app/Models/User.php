<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'role', 'cin_recto', 'cin_verso'
    ];

    // Un utilisateur peut posséder plusieurs objets
    public function objets()
    {
        return $this->hasMany(Objet::class, 'proprietaire_id');
    }

    // Un utilisateur peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    // Un utilisateur peut recevoir plusieurs notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    // Un utilisateur peut avoir plusieurs réclamations
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'utilisateur_id');
    }
}