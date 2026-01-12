<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialLink extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'social_links';

    protected $fillable = [
        'url',
        'type',
        'socialable_id',
        'socialable_type',
    ];

    public function socialable()
    {
        return $this->morphTo();
    }

}
