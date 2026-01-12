<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationType extends Model
{
    use SoftDeletes;
    protected $table = 'certification_types';

    protected $fillable = [
        'name',
        'description',
    ];
}