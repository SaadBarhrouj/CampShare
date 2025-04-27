<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'phone_number', 'address', 'role',
        'avatar_url', 'cin_recto', 'cin_verso', 'is_subscriber', 'is_active', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'item_id');
    }

    public function clientReservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function partnerReservations()
    {
        return $this->hasMany(Reservation::class, 'partner_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }


   
}
