<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentParticipation extends Model
{
    protected $fillable = [
        'level',
        'name',
        'match_evaluation_id',
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }
}
