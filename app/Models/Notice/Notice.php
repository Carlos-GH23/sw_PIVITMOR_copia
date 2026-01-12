<?php

namespace App\Models\Notice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Catalogs\NewsCategory;
use App\Models\Photo;
use App\Models\Keyword;
use Illuminate\Support\Str;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notices';

    protected $fillable = [
        'title',
        'subtitle',
        'abstract',
        'notice_body',
        'notice_source',
        'author',
        'creation_date',
        'publication_date',
        'email_notification',
        'news_category_id',
        'notice_status_id',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($notice) {
            $slugBase = Str::slug($notice->title);
            $slug = $slugBase;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {

                $slug = $slugBase . '-' . $count++;
            }
            
            $notice->slug = $slug;
        });
    }

    protected $casts = [
        'publication_date' => 'datetime',
    ];

    public function newsCategory()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function noticeStatus()
    {
        return $this->belongsTo(NoticeStatus::class);
    }

    public function keywords(): MorphMany
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }
}
