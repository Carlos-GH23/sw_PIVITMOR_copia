<?php

namespace App\Models\Institution;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institution\Institution;

class InstitutionCategory extends Model
{
    protected $table = 'institution_categories';
    protected $fillable = [
        'code',
        'name'
    ];

    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
