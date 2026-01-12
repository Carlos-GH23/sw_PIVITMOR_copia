<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CieesAccreditationProgram extends Model
{
    protected $fillable = [
        'expiry_date',
        'level',
        'ciees_accreditation_id',
        'academic_offering_id',
    ];

    public function academicOffering(): BelongsTo
    {
        return $this->belongsTo(AcademicOffering::class);
    }

    public function cieesAccreditation(): BelongsTo
    {
        return $this->belongsTo(CieesAccreditation::class);
    }
}
