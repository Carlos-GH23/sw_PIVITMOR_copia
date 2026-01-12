<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'order',
    ];
}
