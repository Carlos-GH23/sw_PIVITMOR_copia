<?php

namespace App\Traits;

use App\Models\Capability;
use App\Models\CapabilityRequirementMatch;
use Illuminate\Support\Facades\Log;

trait RequirementMatchable
{
    use BuildsSemanticContext;

    public function matchType(): string
    {
        return 'necesidad';
    }

    public function canRunMatch(): bool
    {
        return $this->requirement_status_id == 3 && $this->is_active;
    }

    public function matchTextFields(): array
    {
        return [
            $this->title,
            $this->cleanContext($this->technical_description),
            $this->cleanContext($this->need_statement),
            $this->cleanContext($this->potential_applications),
        ];
    }

    public function buildMatchPayload(array $match): array
    {
        return [
            'requirement_id'      => $this->id,
            'capability_id'       => (int) $match['id'],
            'compatibility_score' => (float) $match['similitud'],
        ];
    }

    public function isSameEntityMatch(int $id): bool
    {
        $capability = Capability::find($id);

        if (! $capability) {
            return false;
        }

        $thisEntity = $this->resolveEntityInstance();
        $thatEntity = $capability->resolveEntityInstance();

        if (! $thisEntity || ! $thatEntity) {
            return false;
        }

        return
            $thisEntity->id === $thatEntity->id &&
            $thisEntity->type === $thatEntity->type;
    }

    public function canAcceptMatchWith(int $id): bool
    {
        $capability = Capability::find($id);

        if (! $capability) {
            return false;
        }

        $entity = $capability->resolveEntityInstance();

        if (! $capability->is_active) {
            return false;
        }

        if (! $entity || ! $entity?->is_active) {
            return false;
        }

        if (! $capability->user->is_active) {
            return false;
        }

        return true;
    }
}
