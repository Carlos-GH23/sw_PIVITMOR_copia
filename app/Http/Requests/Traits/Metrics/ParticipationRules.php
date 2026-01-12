<?php

namespace App\Http\Requests\Traits\Metrics;

trait ParticipationRules
{
    public function participationRules(int $limit = 255): array
    {
        return [
            'participations'            => ['nullable', 'array', 'max:' . $limit],
            'participations.*.id'       => ['nullable', 'integer', 'exists:student_participations,id'],
            'participations.*.level'    => ['required', 'string', 'max:255'],
            'participations.*.name'     => ['required', 'string', 'max:255'],
        ];
    }

    public function participationAttributes(): array
    {
        return [
            'participations'                  => 'participaciones estudiantiles',
            'participations.*.level'          => 'nivel de formación',
            'participations.*.name'           => 'descripción de la participación',
        ];
    }
}
