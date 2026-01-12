<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacityCompliance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'privacity_compliances';

    protected $fillable = [
        'version',
        'privacity_advice',
        'is_active',
    ];
}
