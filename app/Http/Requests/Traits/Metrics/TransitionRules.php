<?php

namespace App\Http\Requests\Traits\Metrics;

trait TransitionRules
{
    public function transitionRules(int $limit = 255): array
    {
        return [
            'technology_level_transitions'                  => ['nullable', 'array', 'max:' . $limit],
            'technology_level_transitions.*.id'             => ['nullable', 'integer', 'exists:technology_level_transitions,id'],
            'technology_level_transitions.*.initial_id'     => ['integer', 'exists:technology_levels,id'],
            'technology_level_transitions.*.final_id'       => ['integer', 'exists:technology_levels,id'],
        ];
    }

    public function transitionAttributes(): array
    {
        return [
            'technology_level_transitions'                  => 'transiciones de niveles tecnológicos',
            'technology_level_transitions.*.initial_id'     => 'nivel tecnológico inicial',
            'technology_level_transitions.*.final_id'       => 'nivel tecnológico final',
        ];
    }
}
