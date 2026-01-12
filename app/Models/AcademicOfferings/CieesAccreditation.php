<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CieesAccreditation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public function cieesAccreditationPrograms(): HasMany
    {
        return $this->hasMany(CieesAccreditationProgram::class);
    }
}
