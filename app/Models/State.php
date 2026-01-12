<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
