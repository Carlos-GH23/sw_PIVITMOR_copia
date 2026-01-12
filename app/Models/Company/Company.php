<?php

namespace App\Models\Company;

use App\Contracts\EntityProvider;
use App\Models\Contact;
use App\Models\Institution\Reniecyt;
use App\Models\Keyword;
use App\Models\Location;
use App\Models\PhoneNumber;
use App\Models\Photo;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UnifiedSearchable;

class Company extends Model implements EntityProvider
{
    use HasFactory, SoftDeletes, UnifiedSearchable;
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'legal_name',
        'rfc',
        'year',
        'mission',
        'vision',
        'overview',
        'user_id',
        'is_active',
    ];

    public function getEntityCode(): ?string
    {
        return 'ebt';
    }

    public function getEntityCategory(): ?string
    {
        return 'Empresa de Base Tecnológica';
    }

    public function getEntityName(): ?string
    {
        return $this->name;
    }

    public function loadEntityRelations(): self
    {
        return $this->load('reniecyt');
    }

    public function logo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function reniecyt()
    {
        return $this->morphOne(Reniecyt::class, 'reniecytable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technologyCompany()
    {
        return $this->hasOne(TechnologyCompany::class);
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
            'reniecyt',
            'technologyCompany.oecdSectors',
            'technologyCompany.economicSectors',
            'keywords',
            'phoneNumbers',
            'socialLinks',
        ]);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $this->load('keywords', 'technologyCompany.oecdSectors', 'technologyCompany.economicSectors');
        $location = $this->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'company',
            'oecd_sector_ids' => $this->technologyCompany?->oecdSectors->pluck('id') ?? [],
            'economic_sector_ids' => $this->technologyCompany?->economicSectors->pluck('id') ?? [],
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            // searchable
            'institution_category' => $this->getEntityCategory(),
            'institution_code' => $this->getEntityCode(),
            'institution_name' => $this->getEntityName(),
            'description' => $this->overview,
            'legal_name' => $this->legal_name,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'keywords' => $this->keywords->pluck('name'),
            'oecd_sectors' => $this->technologyCompany?->oecdSectors->pluck('name') ?? [],
            'economic_sectors' => $this->technologyCompany?->economicSectors->pluck('name') ?? [],
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'latitude' => (float) $location?->latitude,
            'longitude' => (float) $location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
