<?php

namespace App\Models\GovernmentAgency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GovernmentAgency\GovernmentLevel;
use App\Models\Catalogs\GovernmentSector;
use App\Models\Photo;
use App\Models\Location;
use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Keyword;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Contracts\EntityProvider;
use App\Traits\UnifiedSearchable;

class GovernmentAgency extends Model implements EntityProvider
{
    use HasFactory, SoftDeletes, UnifiedSearchable;
    protected $table = 'government_agencies';

    protected $fillable = [
        'name',
        'acronym',
        'mission',
        'vision',
        'objectives',
        'government_level_id',
        'government_sector_id',
        'user_id',
        'is_active',
    ];

    public function getEntityCode(): ?string
    {
        return 'gob';
    }

    public function getEntityCategory(): ?string
    {
        return 'Dependencia Gubernamental';
    }

    public function getEntityName(): ?string
    {
        return $this->name;
    }

    public function loadEntityRelations(): self
    {
        return $this->load('governmentLevel', 'governmentSector');
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

    public function governmentLevel()
    {
        return $this->belongsTo(GovernmentLevel::class);
    }

    public function governmentSector()
    {
        return $this->belongsTo(GovernmentSector::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keywords(): MorphMany
    {
        return $this->morphMany(Keyword::class, 'keywordable');
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
            'governmentLevel',
            'governmentSector',
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
        $this->load('keywords');
        $location = $this->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'government_agency',
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            // searchable
            'institution_name' => $this->name,
            'institution_category' => $this->getEntityCategory(),
            'institution_code' => $this->getEntityCode(),
            'description' => $this->objectives,
            'acronym' => $this->acronym,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'keywords' => $this->keywords->pluck('name'),
            'government_level' => $this->governmentLevel?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'latitude' => $location?->latitude,
            'longitude' => $location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
