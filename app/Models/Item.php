<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'partner_id', 'title', 'description', 'price_per_day', 'category_id',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        $visibleReviews = $this->reviews->where('is_visible', true);

        return number_format($visibleReviews->avg('rating'), 1);
    }

    public function fiveStarPercentage($number)
    {
        $visibleReviews = $this->reviews->where('is_visible', true);
        $total = $visibleReviews->count();

        if ($total === 0) return 0;

        $fiveStars = $visibleReviews->where('rating', $number)->count();
        
        return round(($fiveStars / $total) * 100, 1);
    }


    protected $casts = [
        'price_per_day' => 'decimal:2',
    ];


    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }


   
    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

}
