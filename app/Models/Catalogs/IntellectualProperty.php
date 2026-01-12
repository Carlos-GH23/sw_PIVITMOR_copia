<?php

namespace App\Models\Catalogs;

use App\Models\Capability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntellectualProperty extends Model
{
    use HasFactory;

    protected $table = 'intellectual_properties';

    protected $fillable = [
        'name',
    ];

    public function capabilities(): HasMany
    {
        return $this->hasMany(Capability::class);
    }
}
