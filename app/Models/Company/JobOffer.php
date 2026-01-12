<?php

namespace App\Models\Company;

use App\Contracts\EntityResolvable;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\JobOfferType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AcademicDegree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Models\SocialLink;
use App\Models\User;
use App\Enums\Gender;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class JobOffer extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, UnifiedSearchable, MountsEntity;

    protected $table = 'job_offers';

    protected $fillable = [
        'name',
        'position',
        'gender',
        'travel_requirements',
        'job_offer_type_id',
        'academic_degree_id',
        'start_date',
        'end_date',
        'job_description',
        'responsibilities',
        'skills_languages',
        'observations',
        'comments',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    protected static function booted()
    {
        static::creating(function ($jobOffer) {
            if (is_null($jobOffer->user_id)) {
                $jobOffer->user_id = Auth::id();
            }
        });
    }

    public function academicDegree()
    {
        return $this->belongsTo(AcademicDegree::class);
    }

    public function getEntityLoadPaths(): string
    {
        return 'user.company';
    }

    public function resolveEntityInstance()
    {
        return $this->user?->company;
    }

    public function offerType()
    {
        return $this->belongsTo(JobOfferType::class, 'job_offer_type_id');
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class, 'job_offers_oecd_sectors');
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class, 'job_offers_economic_sectors');
    }

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function phoneNumbers()
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'socialable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'academicDegree',
            'offerType',
            'oecdSectors',
            'economicSectors',
            'contact',
            'phoneNumbers',
            'socialLinks',
        ]);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $owner = $this->user->company;
        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'job_offer',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'municipality_id' => $owner->location?->neighborhood?->municipality_id,
            'state_id' => $owner->location?->neighborhood?->municipality?->state_id,
            'social_sector_ids' => $this->economicSectors->pluck('economic_social_sector_id')
                ->merge($this->oecdSectors->pluck('economic_social_sector_id'))
                ->unique()
                ->values()
                ->toArray(),
            // searchable
            'title' => $this->name,
            'description' => $this->job_description,
            'position' => $this->position,
            'job_offer_type' => $this->offerType?->name,
            'academic_degree' => $this->academicDegree?->name,
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'institution_name' => $owner->getEntityName(),
            'institution_category' => $owner->getEntityCategory(),
            'institution_code' => $owner->getEntityCode(),
            'state' => $owner->location?->neighborhood?->municipality?->state?->name,
            'municipality' => $owner->location?->neighborhood?->municipality?->name,
            'latitude' => (float) $owner->location?->latitude,
            'longitude' => (float) $owner->location?->longitude,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
