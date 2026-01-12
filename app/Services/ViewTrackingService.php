<?php

namespace App\Services;

use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\Model;

class ViewTrackingService
{
    public function recordView(Model $model): void
    {
        if (!$model instanceof Viewable) {
            return;
        }

        views($model)->cooldown(now()->addHours(24))->record();
    }

    public function getViewCount(Model $model): int
    {
        if (!$model instanceof Viewable) {
            return 0;
        }

        return views($model)->count();
    }

    public function recordViewByType(string $type, int $id): void
    {
        $modelClass = match ($type) {
            'capability' => Capability::class,
            'requirement' => Requirement::class,
            'technology_service' => TechnologyService::class,
            default => null,
        };

        if (! $modelClass) {
            return;
        }

        $model = $modelClass::find($id);

        if ($model) {
            $this->recordView($model);
        }
    }
}
