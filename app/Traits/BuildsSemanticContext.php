<?php

namespace App\Traits;

use App\Contracts\Matchable;
use App\Models\CapabilityRequirementMatch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait BuildsSemanticContext
{
    protected $similarityThreshold = 0.60;

    protected function buildContext(array $fields, array $relations): string
    {
        return collect($fields)
            ->merge($relations)
            ->filter()
            ->implode('. ');
    }

    protected function cleanContext(?string $text): ?string
    {
        return Str::of($text)
            ->stripTags()
            ->replace('&nbsp;', ' ')
            ->squish()
            ->trim()
            ->toString();
    }

    protected function createMatches(Model&Matchable $model, array $matches): void
    {
        foreach ($this->filterMatches($model, $matches) as $match) {
            CapabilityRequirementMatch::create(
                $model->buildMatchPayload($match)
            );
        }
    }

    private function filterMatches(Model&Matchable $model, array $matches): array
    {
        return collect($matches)
            ->filter(fn($match) => $match['similitud'] > $this->similarityThreshold)
            ->filter(fn($match) => $model->canAcceptMatchWith((int) $match['id']))
            ->reject(fn($match) => $model->isSameEntityMatch((int) $match['id']))
            ->values()
            ->all();
    }
}
