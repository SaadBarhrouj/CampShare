<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'note', 'commentaire', 'date', 'objet_id', 'evaluateur_id', 'evalue_id'
    ];

    // Une évaluation est faite par un évaluateur (User)
    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    // Une évaluation concerne un évalué (User)
    public function evalue()
    {
        return $this->belongsTo(User::class, 'evalue_id');
    }

    // Une évaluation est associée à un objet
    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }
}