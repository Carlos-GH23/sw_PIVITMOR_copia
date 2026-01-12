<?php

namespace App\Models\AcademicOfferings;

use App\Contracts\EntityResolvable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Institution\Department;
use App\Models\File;
use App\Models\Keyword;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;
use App\Models\MatchEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class AcademicOffering extends Model implements EntityResolvable
{
    use HasFactory, UnifiedSearchable, MountsEntity;

    protected $fillable = [
        'name',
        'description',
        'objective',
        'graduate_profile',
        'website',
        'semester_cost',
        'duration_months',
        'revoe',
        'educational_level_id',
        'study_mode_id',
        'department_id',
        'user_id',
        'fimpes_accreditation_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($academicOffering) {
            if (is_null($academicOffering->user_id)) {
                $academicOffering->user_id = Auth::id();
            }
        });
    }

    public function getEntityLoadPaths(): string
    {
        return 'department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->department?->institution;
    }

    public function educationalLevel(): BelongsTo
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function studyMode(): BelongsTo
    {
        return $this->belongsTo(StudyMode::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function copaesAccreditationProgram(): HasOne
    {
        return $this->hasOne(CopaesAccreditationProgram::class);
    }

    public function cieesAccreditationProgram(): HasOne
    {
        return $this->hasOne(CieesAccreditationProgram::class);
    }

    public function fimpesAccreditation(): BelongsTo
    {
        return $this->belongsTo(FimpesAccreditation::class);
    }

    public function postgraduateDetail(): HasOne
    {
        return $this->hasOne(PostgraduateDetail::class);
    }

    public function economicSectors(): BelongsToMany
    {
        return $this->belongsToMany(EconomicSector::class, 'academic_offering_economic_sector');
    }

    public function oecdSectors(): BelongsToMany
    {
        return $this->belongsToMany(OecdSector::class, 'academic_offering_oecd_sector');
    }

    public function keywords(): MorphMany
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function matchEvaluations()
    {
        return $this->belongsToMany(MatchEvaluation::class);
    }

    public function scopeInstitutionByAcademic($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->where('institution_id', Auth::user()->academic?->department?->institution_id);
        });
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'educationalLevel',
            'studyMode',
            'department',
            'copaesAccreditationProgram.copaesAccreditation',
            'cieesAccreditationProgram.cieesAccreditation',
            'fimpesAccreditation',

            'economicSectors',
            'oecdSectors',
            'keywords',
            'files',
        ]);
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
        $institution = $this->department?->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'academic_offering',
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'social_sector_ids' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->id))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->name,
            'description' => $this->description,
            'keywords' => $this->keywords->pluck('name'),
            'educational_level' => $this->educationalLevel?->name,
            'study_mode' => $this->studyMode?->name,
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'social_sectors' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            'institution_name' => $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'latitude' => $location?->latitude,
            'longitude' => $location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
