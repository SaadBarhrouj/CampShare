<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'objet_id'];

    // Une image appartient à un objet
    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }
}