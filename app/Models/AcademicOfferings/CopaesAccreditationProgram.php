<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CopaesAccreditationProgram extends Model
{
    protected $fillable = [
        'expiry_date',
        'copaes_accreditation_id',
        'academic_offering_id',
    ];

    public function academicOffering(): BelongsTo
    {
        return $this->belongsTo(AcademicOffering::class);
    }

    public function copaesAccreditation(): BelongsTo
    {
        return $this->belongsTo(CopaesAccreditation::class);
    }
}
