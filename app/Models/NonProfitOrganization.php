<?php

namespace App\Models;

use App\Contracts\EntityProvider;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\LegalEntityType;
use App\Models\Company\MarketReach;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UnifiedSearchable;

class NonProfitOrganization extends Model implements EntityProvider
{
    use HasFactory, SoftDeletes, UnifiedSearchable;
    protected $table = 'non_profit_organizations';

    protected $fillable = [
        'name',
        'description',
        'mission',
        'main_projects',
        'cluni',
        'rfc',
        'legal_representative',
        'economic_sector_id',
        'legal_entity_type_id',
        'market_reach_id',
        'user_id',
        'is_active',
    ];

    public function getEntityCode(): ?string
    {
        return 'ong';
    }

    public function getEntityCategory(): ?string
    {
        return 'Organización No Gubernamental';
    }

    public function getEntityName(): ?string
    {
        return $this->name;
    }

    public function loadEntityRelations(): self
    {
        return $this->load('legalEntityType', 'economicSector');
    }

    public function economicSector(): BelongsTo
    {
        return $this->belongsTo(EconomicSector::class);
    }

    public function contact(): MorphOne
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function legalEntityType(): BelongsTo
    {
        return $this->belongsTo(LegalEntityType::class);
    }

    public function location(): MorphOne
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function marketReach(): BelongsTo
    {
        return $this->belongsTo(MarketReach::class);
    }

    public function phoneNumbers(): MorphMany
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function socialLinks(): MorphMany
    {
        return $this->morphMany(SocialLink::class, 'socialable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'logo',
            'location',
            'contact',
            'economicSector',
            'legalEntityType',
            'marketReach',
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
            'resource_type' => 'non_profit',
            'economic_sector_ids' => $this->economic_sector_id ? [$this->economic_sector_id] : [],
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            // searchable
            'institution_name' => $this->name,
            'institution_code' => $this->getEntityCode(),
            'institution_category' => $this->getEntityCategory(),
            'description' => $this->description,
            'mission' => $this->mission,
            'main_projects' => $this->main_projects,
            'cluni' => $this->cluni,
            'legal_representative' => $this->legal_representative,
            'keywords' => $this->keywords->pluck('name'),
            'economic_sectors' => $this->economicSector?->pluck('name'),
            'legal_entity_type' => $this->legalEntityType?->name,
            'market_reach' => $this->marketReach?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'neighborhood' => $location?->neighborhood?->name,
            'latitude' => $location?->latitude,
            'longitude' => $location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
