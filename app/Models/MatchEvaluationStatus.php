<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchEvaluationStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    public function evaluations()
    {
        return $this->hasMany(MatchEvaluation::class);
    }
}
