<?php

namespace App\Models\AcademicGroups;

use Illuminate\Database\Eloquent\Model;

class AcademicDiscipline extends Model
{
    protected $table = 'academic_disciplines';
    protected $fillable = ['name'];

    public function academicBodies()
    {
        return $this->hasMany(AcademicBody::class);
    }
}
