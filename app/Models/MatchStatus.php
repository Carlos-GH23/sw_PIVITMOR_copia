<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    public function capabilityRequirementMatch()
    {
        return $this->belongsTo(CapabilityRequirementMatch::class);
    }
}
