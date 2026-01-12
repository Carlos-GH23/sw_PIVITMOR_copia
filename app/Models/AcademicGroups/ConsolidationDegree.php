<?php

namespace App\Models\AcademicGroups;

use Illuminate\Database\Eloquent\Model;

class ConsolidationDegree extends Model
{
    protected $table = 'consolidation_degrees';
    protected $fillable = ['name', 'level'];
    
    public function academicBodies()
    {
        return $this->hasMany(AcademicBody::class);
    }
}
