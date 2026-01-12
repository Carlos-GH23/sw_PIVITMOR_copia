<?php

namespace App\Models;

use App\Models\Catalogs\TechnologyLevel;
use Illuminate\Database\Eloquent\Model;

class TechnologyLevelTransition extends Model
{
    protected $fillable = [
        'match_evaluation_id',
        'initial_id',
        'final_id'
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }

    public function initialLevel()
    {
        return $this->belongsTo(TechnologyLevel::class, 'initial_id');
    }

    public function finalLevel()
    {
        return $this->belongsTo(TechnologyLevel::class, 'final_id');
    }
}
