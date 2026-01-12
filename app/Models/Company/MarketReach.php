<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketReach extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'market_reaches';

    protected $fillable = [
        'name',
    ];
}
