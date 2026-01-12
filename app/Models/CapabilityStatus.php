<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CapabilityStatus extends Model
{
    use HasFactory;

    protected $table = 'capability_statuses';

    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function capabilities(): HasMany
    {
        return $this->hasMany(Capability::class);
    }
}
