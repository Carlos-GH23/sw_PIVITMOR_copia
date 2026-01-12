<?php

namespace App\Models\Catalogs;

use App\Models\Capability;
use App\Models\TechnologyService;
use App\Models\Conference;
use App\Models\Company\JobOffer;
use App\Models\EconomicSocialSector;
use App\Models\Requirement;
use App\Traits\HasHierarchy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OecdSector extends Model
{
    use HasHierarchy, SoftDeletes;

    protected $table = 'oecd_sectors';

    protected $fillable = [
        'name',
        'level',
        'parent_id',
        'economic_social_sector_id',
    ];

    public function capabilities(): BelongsToMany
    {
        return $this->belongsToMany(Capability::class, 'capability_oecd_sector');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(TechnologyService::class, 'oecd_sector_technology_service');
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class, 'conference_oecd_sector');
    }

    public function jobOffers(): BelongsToMany
    {
        return $this->belongsToMany(JobOffer::class, 'oecd_sector_job_offer');
    }

    public function economicSocialSector()
    {
        return $this->belongsTo(EconomicSocialSector::class, 'economic_social_sector_id');
    }
}
