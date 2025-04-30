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
    protected static function booted()
    {
        static::created(function ($listing) {
            $subscribers = User::where('is_subscriber', 1)->get();

            foreach ($subscribers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'message' => 'A new listing has been added: ' . $listing->item->title,
                    'listing_id' => $listing->id,
                    'type' => 'added_listing',
                    'is_read'=>0,
                ]);
            }
        });
        static::updated(function ($listing) {
            $subscribers = User::where('is_subscriber', 1)->get();

            foreach ($subscribers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'message' => 'A listing has been updated: ' . $listing->item->title,
                    'listing_id' => $listing->id,
                    'type' => 'updated_listing',
                    'is_read'=>0,

                ]);
            }
        });
    }
    
}
