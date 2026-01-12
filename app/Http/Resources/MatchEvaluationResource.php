<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasMatchEvaluationMetrics;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchEvaluationResource extends JsonResource
{
    use DateFormat;
    use HasMatchEvaluationMetrics;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'story' => $this->story,
                'results' => $this->results,
                'goals' => $this->goals,
                'lessons' => $this->lessons,
                'rating' => $this->rating,
                'training_hours' => $this->training_hours,
                'economic_estimate' => $this->economic_estimate,
                'productivity_increase' => $this->productivity_increase,
                'territorial_level' => $this->territorial_level,
                'emissions_percentage' => $this->emissions_percentage,
                'emissions_methodology' => $this->emissions_methodology,
                'community_impact_level' => $this->community_impact_level,
                'inclusion_equity_level' => $this->inclusion_equity_level,
                'project_sustainability_status' => $this->project_sustainability_status,
                'continuity_percentage' => $this->continuity_percentage,
                'continuity_type' => $this->continuity_type,
                'communication_management_percentage' => $this->communication_management_percentage,
                'infrastructure_level' => $this->infrastructure_level,
                'estimated_investment' => $this->estimated_investment,
                'maturity_level' => $this->maturity_level,
                'structure_type' => $this->structure_type,
                'public_service_percentage' => $this->public_service_percentage,
                'transparency_level' => $this->transparency_level,
                'process_digitalization_percentage' => $this->process_digitalization_percentage,
                'process_simplification_percentage' => $this->process_simplification_percentage,
                'interoperability_level' => $this->interoperability_level,
                'evaluated_at' => $this->evaluated_at,
                'is_success_story' => $this->is_success_story,

                'match_evaluation_status_id' => $this->match_evaluation_status_id,
                'user_id' => $this->user_id,
                'match' => new CapabilityRequirementMatchResource($this->whenLoaded('match')),
                'status' => new MatchEvaluationStatusResource($this->whenLoaded('matchEvaluationStatus')),
                'user' => new UserResource($this->whenLoaded('user')),
                'categories' => MatchEvaluationCategoryResource::collection($this->whenLoaded('categories')),
                'created_at' => $this->textFormatDate($this->created_at, true),
            ],
            $this->getMetrics()
        );
    }
}
