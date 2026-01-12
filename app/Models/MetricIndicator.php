<?php

namespace App\Models;

use App\Enums\MetricIndicatorType;
use Illuminate\Database\Eloquent\Model;

class MetricIndicator extends Model
{
    protected $fillable = [
        'name',
        'type',
        'indicatorable_id',
        'indicatorable_type',
    ];

    protected $casts = [
        'type' => MetricIndicatorType::class,
    ];

    public function indicatorable()
    {
        return $this->morphTo();
    }
}
