<?php

namespace App\Models\Catalogs;

use App\Models\Capability;
use App\Traits\HasHierarchy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, HasHierarchy, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'name',
        'description',
        'parent_id',
    ];
    
    public function capabilities(): BelongsToMany
     {
        return $this->belongsToMany(Capability::class, 'activity_capability');
    }
}
