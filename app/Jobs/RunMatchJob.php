<?php

namespace App\Jobs;

use App\Contracts\Matchable;
use App\Traits\BuildsSemanticContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class RunMatchJob implements ShouldQueue
{
    use Queueable;
    use BuildsSemanticContext;

    protected Model&Matchable $model;

    /**
     * Create a new job instance.
     */
    public function __construct(Model&Matchable $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::timeout(10)
                ->retry(3, 200)
                ->post(
                    rtrim(config('services.matching.url'), '/') . '/add/',
                    [
                        'id_doc' => (string) $this->model->id,
                        'tipo'   => (string) $this->model->matchType(),
                        'texto'  => (string) $this->getContext(),
                    ]
                );

            if (! $response->successful()) throw new RuntimeException('Matching service error: ' . $response->status());

            Log::info($response);

            DB::transaction(function () use ($response) {
                $this->createMatches($this->model, data_get($response->json(), 'comparaciones'));
                $this->model->update(['matching_executed' => true]);
            });
        } catch (\Throwable $e) {
            Log::error('Matching failed', ['model_id' => $this->model->id, 'model_type' => $this->model->matchType(), 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    private function getContext(): string
    {
        $this->model->load([
            'keywords',
            'intellectualProperty',
            'technologyLevel',
            'oecdSectors',
            'economicSectors',
        ]);

        return $this->buildContext(
            $this->model->matchTextFields(),
            $this->relationNames()
        );
    }

    private function relationNames(): array
    {
        return collect([
            'keywords',
            'oecdSectors',
            'economicSectors',
        ])
            ->flatMap(
                fn($relation) =>
                $this->model->{$relation}?->pluck('name')->all() ?? []
            )
            ->merge([
                optional($this->model->intellectualProperty)->name,
                optional($this->model->technologyLevel)->name,
            ])
            ->filter()
            ->all();
    }
}
