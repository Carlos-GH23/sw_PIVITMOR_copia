<?php

namespace App\Models\GovernmentAgency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GovernmentLevel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'government_levels';

    protected $fillable = [
        'name',
        'description',
    ];
}
