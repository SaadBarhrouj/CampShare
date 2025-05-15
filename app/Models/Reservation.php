<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'delivery_option',
        'client_id',
        'partner_id',
        'listing_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'delivery_option' => 'boolean',
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function objectReview()
    {
        return $this->hasOne(Review::class)->where('type', 'forObject');
    }

    public function clientReview()
    {
        return $this->hasOne(Review::class)->where('type', 'forClient');
    }

    public function partnerReview()
    {
        return $this->hasOne(Review::class)->where('type', 'forPartner');
    }

    public function scopeConfirmedOrOngoing($query)
    {
        return $query->whereIn('status', ['confirmed', 'ongoing']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getItemAttribute()
    {
        $this->loadMissing('listing.item');
        return optional($this->listing)->item;
    }
}
