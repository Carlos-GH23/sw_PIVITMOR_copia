<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationStatus extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'academic_certification_statuses';

    protected $fillable = [
        'name',
    ];

    public function certifications()
    {
        return $this->hasMany(AcademicCertification::class);
    }
}
