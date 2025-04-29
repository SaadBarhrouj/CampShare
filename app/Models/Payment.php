<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    use HasFactory;

    protected $fillable = ['partner_id', 'amount', 'payment_date', 'status', 'listing_id'];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
