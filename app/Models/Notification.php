<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;

class Notification extends Model
{
    //

    use HasFactory;

    protected $fillable = ['user_id', 'type', 'message', 'is_read','listing_id','reservation_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id', 'id');
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
    
}
