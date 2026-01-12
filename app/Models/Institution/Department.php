<?php

namespace App\Models\Institution;

use App\Models\Institution\Facility;
use App\Models\Institution\Institution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'institution_id',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected static function booted()
    {
        static::creating(function ($department) {
            if (is_null($department->institution_id)) {
                $department->institution_id = Auth::user()->institution?->id ?? null;
            }
        });
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInstitution($query)
    {
        return $query->where('institution_id', Auth::user()->getInstitutionId())->where('is_active', true);
    }

    public function scopeInstitutionForAcademic($query)
    {
        return $query->where('institution_id', Auth::user()->getInstitutionId())->where('is_active', true);
    }
}
