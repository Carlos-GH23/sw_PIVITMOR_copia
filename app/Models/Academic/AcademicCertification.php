<?php

namespace App\Models\Academic;

use App\Models\Academic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Country;
use App\Models\Academic\CertificationLevel;
use App\Models\Academic\AccreditationEntity;
use App\Models\File;
use App\Models\Academic\CertificationStatus;
use Illuminate\Support\Facades\Auth;

class AcademicCertification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'academic_certifications';
    
    protected $fillable = [
        'name',
        'certification_level_id',
        'description',
        'certifying_entity',
        'accreditation_entity_id',
        'country_id',
        'issue_date',
        'expiry_date',
        'status_id',
        'validity_duration',
        'is_active',
        'academic_id',
    ];

    protected static function booted()
    {
        static::creating(function ($certification) {
            if (is_null($certification->academic_id)) {
                $certification->academic_id = Auth::user()->academic?->id ?? null;
            }
        });
    }

    public function certificationLevel()
    {
        return $this->belongsTo(CertificationLevel::class);
    }

    public function accreditationEntity()
    {
        return $this->belongsTo(AccreditationEntity::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function status()
    {
        return $this->belongsTo(CertificationStatus::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function academic()
    {
        return $this->belongsTo(Academic::class);
    }
}
