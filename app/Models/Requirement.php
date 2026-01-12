<?php

namespace App\Models;

use App\Contracts\EntityResolvable;
use App\Contracts\Matchable;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Institution\Department;
use App\Traits\HasInstitutionRelation;
use App\Traits\HasPublishedAt;
use App\Traits\HasReportFilters;
use App\Traits\IndexesOwnerEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\MountsEntity;
use App\Traits\RequirementMatchable;
use App\Traits\UnifiedSearchable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;


class Requirement extends Model implements EntityResolvable, Viewable, Matchable
{
    use HasFactory;
    use HasInstitutionRelation;
    use IndexesOwnerEntity;
    use MountsEntity;
    use SoftDeletes;
    use UnifiedSearchable;
    use HasPublishedAt;
    use InteractsWithViews;
    use HasReportFilters;
    use RequirementMatchable;

    protected $fillable = [
        'title',
        'technical_description',
        'need_statement',
        'potential_applications',
        'start_date',
        'end_date',
        'is_active',

        'user_id',
        'requirement_status_id',
        'department_id',
        'intellectual_property_id',
        'technology_level_id',

        'published_at',
        'matching_executed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'matching_executed' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($requirement) {
            if (is_null($requirement->user_id)) {
                $requirement->user_id = Auth::id();
            }

            if (is_null($requirement->department_id)) {
                $requirement->department_id = Auth::user()->academic?->department_id ?? null;
            }
        });
    }

    public function scopeStatus(Builder $query, array|int $status): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('requirement_status_id', $status);
        }

        return $query->where('requirement_status_id', $status);
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'photos',
            'keywords',
            'oecdSectors',
            'economicSectors',
            'department',
            'intellectualProperty',
            'technologyLevel',
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

    public function requirementStatus()
    {
        return $this->belongsTo(RequirementStatus::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function intellectualProperty()
    {
        return $this->belongsTo(IntellectualProperty::class);
    }

    public function technologyLevel()
    {
        return $this->belongsTo(TechnologyLevel::class);
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class, 'oecd_sector_requirement');
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class, 'economic_sector_requirement');
    }

    public function capabilityRequirementMatches()
    {
        return $this->hasMany(CapabilityRequirementMatch::class);
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function assessments()
    {
        return $this->morphMany(Assessment::class, 'assessable');
    }

    /**
     * Get the indexable data array for the model.
     */
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
            'resource_type' => 'requirement',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'intellectual_property_id' => $this->intellectual_property_id,
            'technology_level_id' => $this->technology_level_id,
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

    public function getPublishedStatusField(): string
    {
        return 'requirement_status_id';
    }
}
