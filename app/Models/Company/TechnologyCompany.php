<?php

namespace App\Models\Company;

use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnologyCompany extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'technology_companies';

    protected $fillable = [
        'num_employees',
        'description',
        'origen_id',
        'company_size_id',
        'company_id',
        'innovation_type_id',
        'technology_level_id',
        'market_reach_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class);
    }

    public function companySize()
    {
        return $this->belongsTo(CompanySize::class);
    }

    public function innovationType()
    {
        return $this->belongsTo(InnovationType::class);
    }

    public function marketReach()
    {
        return $this->belongsTo(MarketReach::class);
    }

    public function technologyLevel()
    {
        return $this->belongsTo(TechnologyLevel::class);
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class);
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
