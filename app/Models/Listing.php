<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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


    public function notifications()
    {
        return $this->hasMany(Notification::class);
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
    

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'delivery_option' => 'boolean',
        'is_premium' => 'boolean',
        'premium_start_date' => 'date',
    ];

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Reservation::class,
            'listing_id',
            'reservation_id',
            'id',
            'id'
        );
    }


    public function scopeConfirmedOrOngoing($query)
    {
        return $query->whereIn('status', ['confirmed', 'ongoing']);
    }




    public function isAvailable(): bool
    {

        return $this->status === 'active';


    }



    protected function getVisibleObjectReviewsQuery()
    {
        // Utilise la relation HasManyThrough
        return $this->item->reviews
                    ->where('type', 'forObject')
                    ->where('is_visible', true); 
    }


   
    public function getVisibleReviews()
    {
        return $this->getVisibleObjectReviewsQuery();
    }




    public function calculateAverageRating(): float
    {
        return round($this->getVisibleObjectReviewsQuery()->avg('rating') ?? 0, 1);
    }




    public function calculateReviewCount(): int
    {
        return $this->getVisibleObjectReviewsQuery()->count();
    }


    public function calculateRatingPercentage(int $starRating): float
    {
        $queryBuilder = $this->getVisibleObjectReviewsQuery();
        $totalVisibleReviews = (clone $queryBuilder)->count();


        if ($totalVisibleReviews === 0) {
            return 0.0;
        }


        $starCount = (clone $queryBuilder)->where('rating', $starRating)->count();


        return round(($starCount / $totalVisibleReviews) * 100);
    }


    public function getRatingData(): array
    {
        $average = $this->calculateAverageRating();
        $count = $this->calculateReviewCount();
        $percentages = [];
        if ($count > 0) {
            for ($i = 5; $i >= 1; $i--) {
                $percentages[$i] = $this->calculateRatingPercentage($i);
            }
        }


        return [
            'average' => $average,
            'count' => $count,
            'percentages' => $percentages,
        ];
    }


    // reviews fati
    public function reviewss()
    {
        return $this->item->reviews();
    }
    

public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
