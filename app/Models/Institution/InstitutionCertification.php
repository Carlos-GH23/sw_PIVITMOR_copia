<?php

namespace App\Models\Institution;

use App\Contracts\EntityResolvable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\CertificationType;
use App\Models\Institution\Department;
use App\Models\Catalogs\ResourceType;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class InstitutionCertification extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, UnifiedSearchable, MountsEntity;

    protected $table = 'institution_certifications';

    protected $fillable = [
        'name',
        'description',
        'certification_type_id',
        'certifying_entity',
        'is_active',
        'resource_type_id',
        'department_id',
        'certified_resource_id',
        'certified_resource_type',
    ];

    protected static function booted()
    {
        static::creating(function ($institutionCertification) {
            if (is_null($institutionCertification->institution_id)) {
                $institutionCertification->institution_id = Auth::user()->institution?->id ?? null;
            }
            if (is_null($institutionCertification->department_id)) {
                $department = Auth::user()->institution
                    ? Auth::user()->institution->departments()->first()
                    : null;
                $institutionCertification->department_id = $department?->id;
            }
        });
    }

    public static function getCsvColumnMapping(): array
    {
        return [
            'name' => 'name',
            'description' => 'description',
        ];
    }

    public static function getCsvValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function getEntityLoadPaths(): string
    {
        return 'department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->department?->institution;
    }

    public function certificationType()
    {
        return $this->belongsTo(CertificationType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function certifiedResource()
    {
        return $this->morphTo();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'certificationType',
            'certifiedResource',
            'department',
            'files',
            'resourceType',
        ]);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->institution();
        });
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $institution = $this->department?->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'institution_certification',
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->name,
            'description' => $this->description,
            'certification_type' => $this->certificationType?->name,
            'certifying_entity' => $this->certifying_entity,
            'institution_name' => $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
