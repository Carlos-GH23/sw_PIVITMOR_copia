<?php

namespace App\Models\Catalogs;

use App\Models\Capability;
use App\Models\TechnologyService;
use App\Models\Company\JobOffer;
use App\Models\Conference;
use App\Models\EconomicSocialSector;
use App\Traits\HasHierarchy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EconomicSector extends Model
{
    use HasFactory, HasHierarchy, SoftDeletes;

    protected $table = 'economic_sectors';

    protected $fillable = [
        'name',
        'level',
        'parent_id',
        'economic_social_sector_id',
    ];

    public function capabilities(): BelongsToMany
    {
        return $this->belongsToMany(Capability::class, 'capability_economic_sector');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(TechnologyService::class, 'economic_sector_technology_service');
    }

    public function jobOffers(): BelongsToMany
    {
        return $this->belongsToMany(JobOffer::class, 'economic_sector_job_offer');
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class, 'conference_economic_sector');
    }

    public function economicSocialSector()
    {
        return $this->belongsTo(EconomicSocialSector::class, 'economic_social_sector_id');
    }
}
