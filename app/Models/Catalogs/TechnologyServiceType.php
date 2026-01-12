<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnologyServiceType extends Model
{
    use SoftDeletes;

    protected $table = 'technology_service_types';

    protected $fillable = [
        'code',
        'category_id',
        'name',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(TechnologyServiceCategory::class, 'category_id');
    }
}
