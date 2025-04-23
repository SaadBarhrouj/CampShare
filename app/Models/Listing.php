<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'partner_id', 'city_id', 'title', 'description', 'price_per_day',
        'status', 'is_premium', 'premium_start_date', 'premium_end_date',
        'category_id', 'delivery_option'
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function availabilities()
    {
        return $this->hasOne(Availability::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function averageRating()
    {
        return number_format($this->reviews->avg('rating'), 1);
    }

    public function fiveStarPercentage($number)
    {
        $total = $this->reviews->count();
        if ($total === 0) return 0;
        $fiveStars = $this->reviews->where('rating', $number)->count();
        return round(($fiveStars / $total) * 100, 1);
    }
}
