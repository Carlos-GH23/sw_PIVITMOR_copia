<?php

namespace App\Http\Resources\Traits;

use App\Enums\ImpactMetricType;
use App\Enums\MetricIndicatorType;
use App\Http\Resources\MetricIndicatorResource;

trait HasMatchEvaluationMetrics
{
    public function getMetrics(): array
    {
        $metrics = [];

        // Impact Metrics (Many to Many)
        foreach (ImpactMetricType::cases() as $type) {
            $metrics[$type->value] = $this->impactMetrics
                ->where('type', $type->value)
                ->pluck('id')
                ->values();
        }

        // Metric Indicators (Polymorphic One to Many)
        foreach (MetricIndicatorType::cases() as $type) {
            $metrics[$type->value] = MetricIndicatorResource::collection(
                $this->metricIndicators->where('type', $type->value)
            );
        }

        // Other Relationships
        $metrics['technology_level_transitions'] = $this->technologyLevelTransitions;
        $metrics['participations'] = $this->studentParticipations;
        $metrics['testimonials'] = $this->testimonials;
        $metrics['partnership_agreements'] = $this->partnershipAgreements;
        $metrics['recognitions'] = $this->institutionalRecognitions;
        $metrics['derived_policies'] = $this->derivedPolicies;
        $metrics['academic_offerings'] = $this->academicOfferings->pluck('id')->values();

        return $metrics;
    }
}
