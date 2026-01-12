<?php

namespace App\Models\Institution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reniecyt extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'reniecyts';

    protected $fillable = [
        'register_number',
        'start_date',
        'end_date',
        'reniecytable_id',
        'reniecytable_type',
    ];
}
