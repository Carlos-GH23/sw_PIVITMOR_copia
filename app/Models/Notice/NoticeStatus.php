<?php

namespace App\Models\Notice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoticeStatus extends Model
{
    use HasFactory;

    protected $table = 'notice_statuses';

    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

}
