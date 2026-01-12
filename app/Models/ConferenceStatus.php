<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConferenceStatus extends Model
{
    use HasFactory;

    protected $table = 'conference_statuses';

    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function conferences(): HasMany
    {
        return $this->hasMany(Conference::class);
    }
}
