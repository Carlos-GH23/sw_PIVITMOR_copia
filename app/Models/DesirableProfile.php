<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DesirableProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'academic_id',
    ];
    public function academic()
    {
        return $this->belongsTo(Academic::class);
    }
}
