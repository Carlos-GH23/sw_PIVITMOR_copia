<?php

namespace App\Models;

use App\Enums\MatchAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MatchLog extends Model
{
    protected $fillable = [
        'action',
        'description',
        'capability_requirement_match_id',
        'user_id',
    ];

    protected $casts = [
        'action' => MatchAction::class,
    ];

    protected static function booted()
    {
        static::creating(function ($matchLog) {
            if (is_null($matchLog->user_id) && Auth::check()) {
                $matchLog->user_id = Auth::id();
            }
        });
    }

    public function capabilityRequirementMatch()
    {
        return $this->belongsTo(CapabilityRequirementMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
