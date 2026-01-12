<?php

namespace App\Http\Resources\Notice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Catalogs\NewsCategoryResource;
use App\Http\Resources\Notice\NoticeStatusResource;
use App\Http\Resources\PhotoResource;
use App\Traits\DateFormat;


class NoticeResource extends JsonResource
{
    use DateFormat;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'abstract' => $this->abstract,
            'notice_body' => $this->notice_body,
            'notice_source' => $this->notice_source,
            'author' => $this->author,
            'creation_date' => $this->creation_date,
            'publication_date' => $this->publication_date ? $this->publication_date->format('Y-m-d') : null,
            'formatted_date' => $this->textFormatDate($this->publication_date),
            'email_notification' => $this->email_notification,
            'news_category_id' => $this->news_category_id,
            'slug' => $this->slug,
            'category' => new NewsCategoryResource($this->whenLoaded('newsCategory')),
            'notice_status_id' => $this->notice_status_id,
            'status' => new NoticeStatusResource($this->whenLoaded('noticeStatus')),
            'keywords' => $this->whenLoaded('keywords', $this->keywords),
            'photo' => new PhotoResource($this->whenLoaded('photo')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
