<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GovernmentAgency\GovernmentAgency;

class GovernmentSector extends Model
{
    use HasFactory;

    protected $table = 'government_sectors';
    
    protected $fillable = [
        'name',
        'description'
    ];

    public function governmentAgencies()
    {
        return $this->hasMany(GovernmentAgency::class);
    }
}
