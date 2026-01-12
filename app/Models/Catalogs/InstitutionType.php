<?php

namespace App\Models\Catalogs;

use App\Models\Institution\InstitutionCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormat;

class InstitutionType extends Model
{
    use HasFactory, SoftDeletes, DateFormat;

    protected $fillable = [
        'code',
        'name',
        'description',
        'institution_category_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function institutionCategory()
    {
        return $this->belongsTo(InstitutionCategory::class);
    }
}
