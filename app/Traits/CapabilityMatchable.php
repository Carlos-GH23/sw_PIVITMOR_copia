<?php

namespace App\Traits;

use App\Models\CapabilityRequirementMatch;
use App\Models\Requirement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait CapabilityMatchable
{
    use BuildsSemanticContext;

    public function matchType(): string
    {
        return 'oferta';
    }

    public function canRunMatch(): bool
    {
        return $this->capability_status_id === 3 && $this->is_active;
    }

    public function matchTextFields(): array
    {
        return [
            $this->title,
            $this->cleanContext($this->technical_description),
            $this->cleanContext($this->problem_statement),
            $this->cleanContext($this->potential_applications),
        ];
    }

    public function buildMatchPayload(array $match): array
    {
        return [
            'capability_id'       => $this->id,
            'requirement_id'      => (int) $match['id'],
            'compatibility_score' => (float) $match['similitud'],
        ];
    }

    public function isSameEntityMatch(int $id): bool
    {
        $requirement = Requirement::find($id);

        if (! $requirement) {
            return false;
        }

        $thisEntity = $this->resolveEntityInstance();
        $thatEntity = $requirement->resolveEntityInstance();

        if (! $thisEntity || ! $thatEntity) {
            return false;
        }

        return
            $thisEntity->id === $thatEntity->id &&
            $thisEntity->type === $thatEntity->type;
    }

    public function canAcceptMatchWith(int $id): bool
    {
        $requirement = Requirement::find($id);

        if (! $requirement) {
            return false;
        }

        $entity = $requirement->resolveEntityInstance();
        $hasCompletedMatch = CapabilityRequirementMatch::where('requirement_id', $id)->where('match_status_id', 3)->exists();

        if ($hasCompletedMatch) {
            return false;
        }

        if (! $requirement->is_active) {
            return false;
        }

        if (! $entity || ! $entity?->is_active) {
            return false;
        }

        if (! $requirement->user->is_active) {
            return false;
        }

        return true;
    }
}
