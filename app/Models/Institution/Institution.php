<?php

namespace App\Models\Institution;

use App\Contracts\EntityProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Photo;
use App\Models\Location;
use App\Models\Contact;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\KnowledgeArea;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\InstitutionType;
use App\Models\Keyword;
use App\Models\PhoneNumber;
use App\Models\SocialLink;
use App\Models\User;
use App\Traits\UnifiedSearchable;

class Institution extends Model implements EntityProvider
{
    use HasFactory, SoftDeletes, UnifiedSearchable;
    protected $table = 'institutions';

    protected $fillable = [
        'name',
        'description',
        'contact_id',
        'institution_type_id',
        'user_id',
        'is_active',
    ];

    public function getEntityCode(): ?string
    {
        return strtolower($this->institutionType?->institutionCategory?->code);
    }

    public function getEntityCategory(): ?string
    {
        return $this->institutionType?->institutionCategory?->name;
    }

    public function getEntityName(): ?string
    {
        return $this->name;
    }

    public function loadEntityRelations(): self
    {
        return $this->load('institutionType', 'reniecyt');
    }

    public function logo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function institutionType()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function reniecyt()
    {
        return $this->morphOne(Reniecyt::class, 'reniecytable');
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class, 'institution_discipline');
    }

    public function knowledgeAreas()
    {
        return $this->belongsToMany(KnowledgeArea::class);
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function phoneNumbers()
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'socialable');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'logo',
            'location',
            'contact',
            'institutionType.institutionCategory',
            'reniecyt',
            'oecdSectors',
            'knowledgeAreas',
            'economicSectors',
            'phoneNumbers',
            'socialLinks',
        ]);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $this->load([
            'economicSectors.economicSocialSector',
            'oecdSectors.economicSocialSector'
        ]);
        $location = $this->location;
        $resource = $this->getEntityCode() === 'ies' ? 'higher_education' : 'research_center';

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => $resource,
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
            // searchable
            'institution_name' => $this->name,
            'institution_type' => $this->institutionType?->name,
            'institution_code' => $this->getEntityCode(),
            'institution_category' => $this->getEntityCategory(),
            'description' => $this->description,
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
            'knowledge_areas' => $this->knowledgeAreas->pluck('name'),
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'social_sectors' => collect($this->economicSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->merge($this->oecdSectors->map(fn($sector) => $sector->economicSocialSector?->name))
                ->filter()
                ->unique()
                ->values()
                ->toArray(),
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'latitude' => $location?->latitude,
            'longitude' => $location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
