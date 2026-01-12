<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Conference;



class AudienceType extends Model
{
    use HasFactory;
    protected $table = 'audience_types';

    protected $fillable = ['type'];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_audience_type');
    }
}





