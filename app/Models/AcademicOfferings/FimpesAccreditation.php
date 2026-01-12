<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FimpesAccreditation extends Model
{
    use HasFactory;

    protected $fillable = ['name']; 

    public function academicOfferings(): HasMany
    {
        return $this->hasMany(AcademicOffering::class);
    }
}
