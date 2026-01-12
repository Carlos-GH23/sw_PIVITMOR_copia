<?php

namespace App\Listeners;

use App\Contracts\Matchable;
use App\Events\MatchingShouldRun;
use App\Jobs\RunMatchJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DispatchRunMatchingJob
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MatchingShouldRun $event): void
    {
        $model = $event->model->refresh();

        if (! $this->canRun($model)) {
            return;
        }

        RunMatchJob::dispatch($model);
    }

    private function canRun(Model $model): bool
    {
        if (! $model instanceof Matchable) {
            return false;
        }

        if (! $model->canRunMatch()) {
            return false;
        }

        if ($model->matching_executed) {
            return false;
        }

        return true;
    }
}
