<?php

namespace App\Models\AcademicOfferings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostgraduateDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_offering_id',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function academicOffering(): BelongsTo
    {
        return $this->belongsTo(AcademicOffering::class);
    }
}
