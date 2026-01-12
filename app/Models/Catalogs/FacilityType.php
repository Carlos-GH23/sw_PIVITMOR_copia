<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution\Facility;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facility_types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
