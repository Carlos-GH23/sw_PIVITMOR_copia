<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Academic\AcademicCertification;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';
    
    protected $fillable = [
        'name',
        'code',
    ];

    public function academicCertifications()
    {
        return $this->hasMany(AcademicCertification::class, 'country_id');
    }
}
