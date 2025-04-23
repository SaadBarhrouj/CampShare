<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    //

    use HasFactory;

    protected $fillable = ['listing_id', 'start_date', 'end_date'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
