<?php

namespace App\Models\Institution;

use App\Models\Academic;
use App\Models\TechnologyService;
use App\Contracts\EntityResolvable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasHierarchy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\EquipmentType;
use App\Models\Photo;
use App\Models\File;
use App\Models\Institution\Facility;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class FacilityEquipment extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, HasHierarchy, UnifiedSearchable, MountsEntity;

    protected $table = 'facility_equipments';

    protected $fillable = [
        'name',
        'description',
        'equipment_type_id',
        'facility_id',
        'responsible_id',
        'status',
        'department_id',
    ];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Academic::class, 'responsible_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getEntityLoadPaths(): string
    {
        return 'department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->department?->institution;
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function technologyServices()
    {
        return $this->belongsToMany(TechnologyService::class, 'equipment_technology_service');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'photos',
            'files',
            'equipmentType',
            'facility',
            'responsible',
            'department',
        ]);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('facility.department', function ($q) {
            $q->institution();
        });
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $institution = $this->facility?->department?->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'equipment',
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->name,
            'description' => $this->description,
            'equipment_type' => $this->equipmentType?->name,
            'facility_name' => $this->facility?->name,
            'responsible_name' => $this->responsible?->name,
            'institution_name' => $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
