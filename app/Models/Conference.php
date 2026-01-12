<?php

namespace App\Models;

use App\Contracts\EntityResolvable;
use App\Models\Catalogs\KnowledgeArea;
use App\Models\Catalogs\OecdSector;
use App\Models\Institution\Department;
use App\Models\Language;
use App\Models\AudienceType;
use App\Models\Academic;
use App\Models\Catalogs\EconomicSector;
use App\Models\Keyword;
use App\Models\File;
use App\Models\ConferenceStatus;
use App\Traits\HasInstitutionRelation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class Conference extends Model implements EntityResolvable
{
    /** @use HasFactory<\Database\Factories\ConferenceFactory> */
    use HasFactory, SoftDeletes, HasInstitutionRelation, UnifiedSearchable, MountsEntity;

    protected $table = 'conferences';

    protected $fillable = [
        'title',
        'description',
        'speaker_bio',
        'modality',
        'language_id',
        'department_id',
        'start_date',
        'end_date',
        'technical_requirements',
        'user_id',
        'conference_status_id',
    ];

    protected static function booted()
    {
        static::creating(function ($conference) {
            if (is_null($conference->user_id)) {
                $conference->user_id = Auth::id();
            }
        });
    }

    public function scopeStatus(Builder $query, array|int $status): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('conference_status_id', $status);
        }

        return $query->where('conference_status_id', $status);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->where('institution_id', Auth::user()->institution?->id);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function academics()
    {
        return $this->belongsToMany(Academic::class, 'conference_academics');
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class, 'conference_oecd_sector');
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class, 'conference_economic_sector');
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function audienceTypes()
    {
        return $this->belongsToMany(AudienceType::class, 'conference_audience_type');
    }

    public function conferenceStatus()
    {
        return $this->belongsTo(ConferenceStatus::class, 'conference_status_id');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'academics.photo',
            'academics.department',
            'academics.academicPosition',
            'audienceTypes',
            'conferenceStatus',
            'department',
            'files',
            'keywords',
            'language',
            'oecdSectors',
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
            'resource_type' => 'conference',
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
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords->pluck('name'),
            'language' => $this->language?->name,
            'modality' => $this->modality,
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
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
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
