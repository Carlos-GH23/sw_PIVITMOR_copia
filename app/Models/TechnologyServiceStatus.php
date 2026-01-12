<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class TechnologyServiceStatus extends Model
{
    use HasFactory;

    protected $table = 'technology_service_statuses';

    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function technologyServices(): HasMany
    {
        return $this->hasMany(TechnologyService::class);
    }
}
