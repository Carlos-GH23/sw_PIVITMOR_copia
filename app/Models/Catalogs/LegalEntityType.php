<?php

namespace App\Models\Catalogs;

use App\Models\NonProfitOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalEntityType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'legal_entity_types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function nonProfitOrganization(): HasMany
    {
        return $this->hasMany(NonProfitOrganization::class);
    }
}
