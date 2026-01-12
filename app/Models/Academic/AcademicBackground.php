<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Catalogs\KnowledgeArea;
use App\Models\AcademicDegree;
use App\Models\File;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class AcademicBackground extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'academic_backgrounds';

    protected $fillable = [ 
        'academic_title',
        'institution_name',
        'academic_degree_id',
        'knowledge_area_id',
        'country_id',
        'degree_obtained_at',
        'certificate_number',
        'academic_body_id',
    ];

    protected static function booted()
    {
        static::creating(function ($academicBackground) {
            if (is_null($academicBackground->academic_id)) {
                $academicBackground->academic_id = Auth::user()->academic?->id ?? null;
            }
        });
    }

    public function academicDegree()
    {
        return $this->belongsTo(AcademicDegree::class);
    }

    public function knowledgeArea()
    {
        return $this->belongsTo(KnowledgeArea::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }


}
