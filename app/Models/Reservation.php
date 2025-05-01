<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'start_date', 'end_date', 'status', 'delivery_option',
        'client_id', 'partner_id', 'listing_id'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }





    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'delivery_option' => 'boolean',
    ];


 
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function objectReview(): HasOne
    {
        return $this->hasOne(Review::class)->where('type', 'forObject');
    }


    public function scopeConfirmedOrOngoing($query)
    {


        return $query->whereIn('status', ['confirmed', 'ongoing']);
    }

}
