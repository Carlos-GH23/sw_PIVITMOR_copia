<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

class Communication extends Model
{
    use HasFactory;

    protected $table = "communications";

    protected $fillable = [
        'subject',
        'recipients',
        'status',
        'body'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
