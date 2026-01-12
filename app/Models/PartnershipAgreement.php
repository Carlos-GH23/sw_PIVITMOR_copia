<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipAgreement extends Model
{
    protected $fillable = [
        'name',
        'agreement_type',
        'match_evaluation_id',
    ];

    public function matchEvaluation()
    {
        return $this->belongsTo(MatchEvaluation::class);
    }
}
