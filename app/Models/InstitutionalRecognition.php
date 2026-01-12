<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionalRecognition extends Model
{
    protected $fillable = [
        'name',
        'recognized_at',
        'url',
        'match_evaluation_id',
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }
}
