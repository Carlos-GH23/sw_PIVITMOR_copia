<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Assessment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'body',
        'is_visible',
        'user_id',
        'assessable_id',
        'assessable_type',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($assessment) {
            if (is_null($assessment->user_id)) {
                $assessment->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessable()
    {
        return $this->morphTo();
    }
}
