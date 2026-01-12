<?php

namespace App\Models\Institution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SniLevel extends Model
{
    use HasFactory;
    protected $table = 'sni_levels';

    protected $fillable = [
        'name',
    ];
}
