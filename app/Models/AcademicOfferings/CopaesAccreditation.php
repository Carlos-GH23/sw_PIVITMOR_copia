<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CopaesAccreditation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function copaesAccreditationPrograms(): HasMany
    {
        return $this->hasMany(CopaesAccreditationProgram::class);
    }
}
