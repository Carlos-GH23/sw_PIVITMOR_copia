<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DerivedPolicy extends Model
{
    protected $fillable = [
        'status',
        'date',
        'url',
        'description',
        'match_evaluation_id',
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }
}
