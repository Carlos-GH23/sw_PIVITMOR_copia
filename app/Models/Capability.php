<?php

namespace App\Models;

use App\Contracts\EntityResolvable;
use App\Contracts\Matchable;
use App\Models\Catalogs\Activity;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Institution\Department;
use App\Traits\CapabilityMatchable;
use App\Traits\HasInstitutionRelation;
use App\Traits\HasPeriod;
use App\Traits\HasPublishedAt;
use App\Traits\HasReportFilters;
use App\Traits\IndexesOwnerEntity;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Capability extends Model implements EntityResolvable, Viewable, Matchable
{
    use HasFactory;
    use HasInstitutionRelation;
    use HasPeriod;
    use IndexesOwnerEntity;
    use MountsEntity;
    use SoftDeletes;
    use UnifiedSearchable;
    use HasPublishedAt;
    use InteractsWithViews;
    use HasReportFilters;
    use CapabilityMatchable;

    protected $table = 'capabilities';

    protected $fillable = [
        'title',
        'technical_description',
        'problem_statement',
        'potential_applications',
        'start_date',
        'end_date',
        'is_active',

        'user_id',
        'capability_status_id',
        'department_id',
        'intellectual_property_id',
        'technology_level_id',

        'published_at',
        'matching_executed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
        'matching_executed' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($capability) {
            if (is_null($capability->user_id)) {
                $capability->user_id = Auth::id();
            }

            if (is_null($capability->department_id)) {
                $capability->department_id = Auth::user()->academic?->department_id ?? null;
            }
        });
    }

    public function toSearchableArray(): array
    {
        $this->loadMissing([
            'keywords',
            'user.academic.department.institution.location.neighborhood',
            'user.academic.department.institution.institutionType',
            'intellectualProperty',
            'technologyLevel',
            'oecdSectors',
            'economicSectors',
            'economicSectors.economicSocialSector',
            'oecdSectors.economicSocialSector',
        ]);

        return array_merge($this->getOwnerSearchData(), [
            'model_id' => $this->id,
            // filtrable
            'resource_type' => 'capability',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'social_sector_ids' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            'intellectual_property_id' => $this->intellectual_property_id,
            'technology_level_id' => $this->technology_level_id,
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

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'academics.department',
            'academics.academicPosition',
            'academics.photo',
            'department',
            'economicSectors',
            'files',
            'intellectualProperty',
            'keywords',
            'oecdSectors',
            'photos',
            'technologyLevel',
        ]);
    }

    public function scopeStatus(Builder $query, array|int $status): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('capability_status_id', $status);
        }

        return $query->where('capability_status_id', $status);
    }

    public function getEntityLoadPaths(): string
    {
        return 'user.academic.department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->user->owner_entity;
    }

    public function capabilityStatus(): BelongsTo
    {
        return $this->belongsTo(CapabilityStatus::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function intellectualProperty(): BelongsTo
    {
        return $this->belongsTo(IntellectualProperty::class);
    }

    public function technologyLevel(): BelongsTo
    {
        return $this->belongsTo(TechnologyLevel::class);
    }

    public function academics(): BelongsToMany
    {
        return $this->belongsToMany(Academic::class, 'academic_capability');
    }

    public function economicSectors(): BelongsToMany
    {
        return $this->belongsToMany(EconomicSector::class, 'capability_economic_sector');
    }

    public function oecdSectors(): BelongsToMany
    {
        return $this->belongsToMany(OecdSector::class, 'capability_oecd_sector');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessments(): MorphMany
    {
        return $this->morphMany(Assessment::class, 'assessable');
    }

    public function keywords(): MorphMany
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function cover()
    {
        return $this->morphOne(Photo::class, 'photoable')->oldestOfMany();
    }

    public function getPublishedStatusField(): string
    {
        return 'capability_status_id';
    }

    public function capabilityRequirementMatches()
    {
        return $this->hasMany(CapabilityRequirementMatch::class);
    }
}
