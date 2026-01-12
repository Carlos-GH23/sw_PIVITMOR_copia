<?php

namespace App\Traits;

trait HasPublishedAt
{
    public static function bootHasPublishedAt(): void
    {
        static::updating(function ($model) {
            $statusField = $model->getPublishedStatusField();
            $publishedStatusId = $model->getPublishedStatusId();

            if (
                $model->isDirty($statusField) &&
                $model->{$statusField} == $publishedStatusId &&
                is_null($model->published_at)
            ) {
                $model->published_at = now();
            }
        });

        static::creating(function ($model) {
            $statusField = $model->getPublishedStatusField();
            $publishedStatusId = $model->getPublishedStatusId();

            if ($model->{$statusField} == $publishedStatusId && is_null($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    abstract public function getPublishedStatusField(): string;

    public function getPublishedStatusId(): int
    {
        return 3;
    }

    public function getTimeToPublishInDays(): ?float
    {
        if (is_null($this->published_at)) {
            return null;
        }

        return $this->created_at->diffInDays($this->published_at, false);
    }

    public function getTimeToPublishInHours(): ?float
    {
        if (is_null($this->published_at)) {
            return null;
        }

        return $this->created_at->diffInHours($this->published_at, false);
    }

    public function scopePublished($query)
    {
        return $query->where($this->getPublishedStatusField(), $this->getPublishedStatusId());
    }

    public function scopeWithPublicationTime($query)
    {
        return $query->whereNotNull('published_at');
    }
}
