<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'reservation_id', 'rating', 'comment', 'is_visible', 'type',
        'reviewer_id', 'reviewee_id', 'item_id'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
