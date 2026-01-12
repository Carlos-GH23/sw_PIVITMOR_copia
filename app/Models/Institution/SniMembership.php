<?php

namespace App\Models\Institution;

use App\Models\Academic;
use App\Models\ResearchArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SniMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'start_date',
        'end_date',
        'academic_id',
        'sni_level_id',
        'research_area_id',
    ];

    public function academic()
    {
        return $this->belongsTo(Academic::class);
    }

    public function researchArea()
    {
        return $this->belongsTo(ResearchArea::class);
    }

    public function sniLevel()
    {
        return $this->belongsTo(SniLevel::class);
    }
}
