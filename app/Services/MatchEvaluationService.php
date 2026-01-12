<?php

namespace App\Services;

use App\Enums\ImpactMetricType;
use App\Models\CapabilityRequirementMatch;
use App\Models\MatchEvaluation;
use App\Enums\MetricIndicatorType;
use App\Traits\HasOrderableMoreRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatchEvaluationService
{
    use HasOrderableMoreRelations;
    protected $matchEvaluation;

    private $otherMetrics = [
        ['relation' => 'technologyLevelTransitions', 'type' => 'technology_level_transitions'],
        ['relation' => 'studentParticipations', 'type' => 'participations'],
        ['relation' => 'testimonials', 'type' => 'testimonials'],
        ['relation' => 'partnershipAgreements', 'type' => 'partnership_agreements'],
        ['relation' => 'institutionalRecognitions', 'type' => 'recognitions'],
        ['relation' => 'derivedPolicies', 'type' => 'derived_policies'],
    ];

    public function __construct(MatchEvaluation $matchEvaluation)
    {
        $this->matchEvaluation = $matchEvaluation;
    }

    protected function getOrderableRelations(): array
    {
        return [
            'capability' => [
                'relations' => ['match', 'capability'],
                'order_column' => 'title',
            ],
            'requirement' => [
                'relations' => ['match', 'requirement'],
                'order_column' => 'title',
            ],
            'compatibility_score' => [
                'relations' => ['match'],
                'order_column' => 'compatibility_score',
            ],
        ];
    }

    public function buildQuery(object $filters)
    {
        $query = MatchEvaluation::query()->with('match.requirement', 'match.capability', 'matchEvaluationStatus')
            ->when($filters->search, function ($query, $search) {
                $query->where('compatibility_score', 'LIKE', "%{$search}%");
                $query->whereRelation('match.requirement', 'title', 'LIKE', "%{$search}%");
                $query->whereRelation('match.capability', 'title', 'LIKE', "%{$search}%");
            })
            ->where('match_evaluation_status_id', 2); // publicadas por el usuario
        return $query;
    }

    public function buildFilters(Builder $query, object $filters)
    {
        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields, CapabilityRequirementMatch $capabilityRequirementMatch): MatchEvaluation | null
    {
        return DB::transaction(function () use ($fields, $capabilityRequirementMatch) {
            $matchEvaluation = $capabilityRequirementMatch->matchEvaluations()->create($fields);
            $matchEvaluation->categories()->attach($fields['categories'] ?? []);
            $matchEvaluation->academicOfferings()->attach($fields['academic_offerings'] ?? []);

            // metrics
            foreach (ImpactMetricType::cases() as $impactMetric) {
                $matchEvaluation->impactMetrics()->attach($fields[$impactMetric->value] ?? []);
            }

            // indicator
            foreach (MetricIndicatorType::cases() as $metricIndicator) {
                $matchEvaluation->metricIndicators()->createMany($fields[$metricIndicator->value] ?? []);
            }

            $this->handleOtherMetrics($matchEvaluation, $fields);
        });
    }

    public function update(array $fields, MatchEvaluation $matchEvaluation): MatchEvaluation | null
    {
        return DB::transaction(function () use ($fields, $matchEvaluation) {
            $matchEvaluation->update($fields);
            $matchEvaluation->categories()->sync($fields['categories'] ?? []);
            $matchEvaluation->academicOfferings()->sync($fields['academic_offerings'] ?? []);

            $impactMetrics = [];
            foreach (ImpactMetricType::cases() as $impactMetric) {
                $impactMetrics = array_merge($impactMetrics, $fields[$impactMetric->value] ?? []);
            }
            $matchEvaluation->impactMetrics()->sync($impactMetrics);

            $matchEvaluation->metricIndicators()->delete();
            foreach (MetricIndicatorType::cases() as $metricIndicator) {
                $matchEvaluation->metricIndicators()->createMany($fields[$metricIndicator->value] ?? []);
            }

            $this->handleOtherMetrics($matchEvaluation, $fields);
        });
    }

    private function handleOtherMetrics(MatchEvaluation $matchEvaluation, array $fields): void
    {
        foreach ($this->otherMetrics as $metric) {
            $relation = $metric['relation'];
            $type = $metric['type'];
            $items = $fields[$type] ?? [];

            $incomingIds = collect($items)
                ->pluck('id')
                ->filter()
                ->values()
                ->toArray();

            $matchEvaluation->{$relation}()
                ->whereNotIn('id', $incomingIds)
                ->delete();

            foreach ($items as $item) {
                if (isset($item['id'])) {
                    $matchEvaluation->{$relation}()
                        ->where('id', $item['id'])
                        ->update($item);
                } else {
                    $matchEvaluation->{$relation}()
                        ->create($item);
                }
            }
        }
    }
}
