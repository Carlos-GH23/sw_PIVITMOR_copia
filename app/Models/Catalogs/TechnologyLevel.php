<?php

namespace App\Models\Catalogs;

use App\Models\Capability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class TechnologyLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'technology_levels';

    protected $fillable = [
        'level',
        'name',
    ];

    /*
    public function technologies()
    {
        return $this->hasMany(Technology::class);
    }
    */

    public function capabilities(): HasMany
    {
        return $this->hasMany(Capability::class);
    }
}
