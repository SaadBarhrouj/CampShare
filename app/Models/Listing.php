<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'item_id', 'status', 'start_date', 'end_date', 'city_id', 'longitude', 'latitude',
        'delivery_option', 'is_premium', 'premium_type', 'premium_start_date'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->item->reviews();
    }
}
