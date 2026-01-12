<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'testimonial',
        'match_evaluation_id',
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }
}
