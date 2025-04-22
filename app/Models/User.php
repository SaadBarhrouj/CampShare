<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'username', 'email', 'password', 'phone_number', 'address', 'role',
        'avatar_url', 'cin_recto', 'cin_verso', 'avg_rating', 'review_count',
        'longitude', 'latitude', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'partner_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'partner_id');
    }

    public function clientReservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function partnerReservations()
    {
        return $this->hasMany(Reservation::class, 'partner_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

   
}
