<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'keywordable_id',
        'keywordable_type',
    ];

    public function keywordable()
    {
        return $this->morphTo();
    }
}
