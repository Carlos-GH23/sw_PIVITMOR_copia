<?php

namespace App\Models\Institution;

use App\Contracts\EntityResolvable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\FacilityType;
use App\Traits\HasHierarchy;
use App\Models\Institution\Department;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Institution\FacilityEquipment;
use App\Models\TechnologyService;
use App\Models\Photo;
use App\Models\File;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Facility extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, HasHierarchy, UnifiedSearchable, MountsEntity;

    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'description',
        'facility_type_id',
        'department_id',
        'is_active',
    ];

    public function toSearchableArray(): array
    {
        $institution = $this->department?->institution;

        return [
            'model_id' => $this->id,
            // filterable
            'municipality_id' => $institution->location?->neighborhood?->municipality_id,
            'state_id' => $institution->location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            'resource_type' => 'facility',
            // searchable
            'title' => $this->name,
            'description' => $this->description,
            'institution_name' => $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,
            'state' => $institution?->location?->neighborhood?->municipality?->state?->name,
            'municipality' => $institution?->location?->neighborhood?->municipality?->name,
            // sortable
            'created_at' => $this->created_at,
        ];
    }

    public static function getCsvColumnMapping(): array
    {
        return [
            'nombre' => 'name',
            'descripcion' => 'description',
        ];
    }

    public static function getCsvValidationRules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:facilities,name',
            'descripcion' => 'nullable|string|max:500',
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

    public function certifications(): MorphMany
    {
        return $this->morphMany(
            InstitutionCertification::class,
            'certifiedResource',
            'certified_resource_type',
            'certified_resource_id',
            'id'
        );
    }

    public function facilityType()
    {
        return $this->belongsTo(FacilityType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function equipments()
    {
        return $this->hasMany(FacilityEquipment::class);
    }

    public function technologyServices()
    {
        return $this->belongsToMany(TechnologyService::class, 'facility_technology_service');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'photos',
            'files',
            'facilityType',
            'department',
            'equipments.equipmentType',
            'certifications.certificationType',
        ]);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->institution();
        });
    }
}
