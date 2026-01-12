<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Notice\Notice;

class NewsCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news_categories';

    protected $fillable = [
        'name',
        'description'
    ];

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}
