<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class JobOfferType extends Model
{
    use SoftDeletes;
    protected $table = 'job_offer_types';

    protected $fillable = [
        'name',
        'description',
    ];
}
