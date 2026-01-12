<?php

namespace App\Models;

use App\Casts\Encrypted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'website',
        'contactable_id',
        'contactable_type',
    ];

    protected $casts = [
        'name' => Encrypted::class,
        'email' => Encrypted::class,
        'website' => Encrypted::class,
    ];

    public function contactable()
    {
        return $this->morphTo();
    }
}
