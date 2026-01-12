<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Contracts\EntityResolvable;
use App\Models\Institution\Department;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Keyword;
use App\Models\Photo;
use App\Models\File;
use App\Models\Assessment;
use App\Models\Catalogs\TechnologyServiceCategory;
use App\Models\Catalogs\TechnologyServiceType;
use App\Traits\HasInstitutionRelation;
use App\Traits\MountsEntity;
use App\Traits\HasPublishedAt;
use App\Traits\HasReportFilters;
use App\Traits\IndexesOwnerEntity;
use App\Traits\UnifiedSearchable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class TechnologyService extends Model implements EntityResolvable, Viewable
{
    use HasFactory;
    use IndexesOwnerEntity;
    use HasInstitutionRelation;
    use MountsEntity;
    use SoftDeletes;
    use UnifiedSearchable;
    use HasPublishedAt;
    use InteractsWithViews;
    use HasReportFilters;

    protected $table = 'technology_services';

    protected $fillable = [
        'title',
        'technical_description',
        'technology_service_type_id',
        'technology_service_category_id',
        'department_id',
        'start_date',
        'end_date',
        'technology_service_status_id',
        'is_active',
        'user_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($technologyService) {
            if (is_null($technologyService->user_id)) {
                $technologyService->user_id = Auth::id();
            }
        });
    }

    public function toSearchableArray(): array
    {
        $this->load([
            'keywords',
            'economicSectors.economicSocialSector',
            'oecdSectors.economicSocialSector'
        ]);

        return array_merge($this->getOwnerSearchData(), [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'technology_service',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'social_sector_ids' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            // searchable
            'title' => $this->title,
            'description' => $this->technical_description,
            'keywords' => $this->keywords->pluck('name'),
            'service_type' => $this->technologyServiceType?->name,
            'service_category' => $this->technologyServiceCategory?->name,
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'social_sectors' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            // sortable
            'created_at' => $this->created_at,
        ]);
    }

    public function scopeStatus(Builder $query, array|int $status): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('technology_service_status_id', $status);
        }

        return $query->where('technology_service_status_id', $status);
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'files',
            'photos',
            'oecdSectors',
            'economicSectors',
            'facilities.facilityType',
            'facilities.department',
            'equipments.equipmentType',
            'equipments.facility',
            'academics.department',
            'academics.academicPosition',
            'academics.photo',
            'keywords',
            'department',
            'technologyServiceType',
            'technologyServiceCategory',
        ]);
    }

    public function getEntityLoadPaths(): array
    {
        return [
            'user.academic.department.institution',
            'user.company',
            'user.governmentAgency',
            'user.nonProfitOrganization',
        ];
    }

    public function resolveEntityInstance()
    {
        return $this->user->owner_entity;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function technologyServiceType()
    {
        return $this->belongsTo(TechnologyServiceType::class, 'technology_service_type_id');
    }

    public function technologyServiceCategory()
    {
        return $this->belongsTo(TechnologyServiceCategory::class, 'technology_service_category_id');
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class, 'oecd_sector_technology_service');
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class, 'economic_sector_technology_service');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_technology_service');
    }

    public function equipments()
    {
        return $this->belongsToMany(
            FacilityEquipment::class,
            'equipment_technology_service',
            'technology_service_id',
            'equipment_id'
        );
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function academics()
    {
        return $this->belongsToMany(Academic::class, 'academic_technology_service');
    }

    public function technologyServiceStatus()
    {
        return $this->belongsTo(TechnologyServiceStatus::class);
    }

    public function assessments(): MorphMany
    {
        return $this->morphMany(Assessment::class, 'assessable');
    }

    public function getPublishedStatusField(): string
    {
        return 'technology_service_status_id';
    }
}
