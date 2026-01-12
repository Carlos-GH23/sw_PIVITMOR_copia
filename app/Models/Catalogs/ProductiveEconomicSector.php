<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductiveEconomicSector extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'productive_economic_sectors';

    protected $fillable = [
        'name',
        'description',
    ];
}
