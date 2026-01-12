<?php

namespace App\Http\Requests\Traits\Metrics;

use App\Enums\ImpactMetricType;

trait ImpactMetricRules
{
    protected function impactMetricRules(): array
    {
        return [
            // scientific_technological
            'scientific_technological'          => ['nullable', 'array'],
            'scientific_technological.*'        => ['integer', 'exists:impact_metrics,id'],

            // economic
            'economic'                          => ['nullable', 'array'],
            'economic.*'                        => ['integer', 'exists:impact_metrics,id'],

            // institutional
            'institutional'                     => ['nullable', 'array'],
            'institutional.*'                   => ['integer', 'exists:impact_metrics,id'],

            // social_environmental
            'social_environmental'              => ['nullable', 'array'],
            'social_environmental.*'            => ['integer', 'exists:impact_metrics,id'],

            // perception_satisfaction
            'perception_satisfaction'           => ['nullable', 'array'],
            'perception_satisfaction.*'         => ['integer', 'exists:impact_metrics,id'],

            // public_innovation
            'public_innovation'                 => ['nullable', 'array'],
            'public_innovation.*'               => ['integer', 'exists:impact_metrics,id'],

            // technological_transfers
            'technological_transfer_metrics'    => ['nullable', 'array'],
            'technological_transfer_metrics.*'  => ['integer', 'exists:impact_metrics,id'],

            // audiences
            'audiences'                         => ['nullable', 'array'],
            'audiences.*'                       => ['integer', 'exists:impact_metrics,id'],

            // sustainable development goals
            'sustainable_development_goals'     => ['nullable', 'array'],
            'sustainable_development_goals.*'   => ['integer', 'exists:impact_metrics,id'],

            // academic programs
            'academic_programs'                 => ['nullable', 'array'],
            'academic_programs.*'               => ['integer', 'exists:impact_metrics,id'],
        ];
    }

    protected function impactMetricAttributes(): array
    {
        return [
            'scientific_technological'          => 'métricas científico-tecnológicas',
            'technological_transfer_metrics'    => 'métricas de transferencia tecnológica',
            'audiences'                         => 'audiencias',
            'economic'                          => 'métricas económicas',
            'social_environmental'              => 'métricas sociales y ambientales',
            'sustainable_development_goals'     => 'metas de desarrollo sostenible',
            'perception_satisfaction'           => 'métricas de percepción y satisfacción',
            'institutional'                     => 'métricas institucionales',
            'public_innovation'                 => 'métricas de innovación pública',
            'academic_programs'                 => 'programas académicos',
        ];
    }
}
