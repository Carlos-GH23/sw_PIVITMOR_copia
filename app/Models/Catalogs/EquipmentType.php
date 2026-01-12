<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution\FacilityEquipment;
use App\Traits\HasHierarchy;

class EquipmentType extends Model
{
    use HasFactory, HasHierarchy, SoftDeletes;

    protected $table = 'equipment_types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function facilityEquipments()
    {
        return $this->hasMany(FacilityEquipment::class);
    }
}
