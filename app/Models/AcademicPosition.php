<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicPosition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public function academics()
    {
        return $this->hasMany(Academic::class);
    }
}
