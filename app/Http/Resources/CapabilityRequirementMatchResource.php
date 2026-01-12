<?php

namespace App\Http\Resources;

use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CapabilityRequirementMatchResource extends JsonResource
{
    use DateFormat;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'compatibility_score' => $this->compatibility_score,
            'matching_algorithm' => $this->matching_algorithm,
            'is_active' => $this->is_active,

            'requirement_id' => $this->requirement_id,
            'capability_id' => $this->capability_id,
            'match_status_id' => $this->match_status_id,

            'requirement' => new RequirementResource($this->whenLoaded('requirement')),
            'capability' => new CapabilityResource($this->whenLoaded('capability')),
            'match_status' => new MatchStatusResource($this->whenLoaded('matchStatus')),

            'offerer_evaluation' => new MatchEvaluationResource($this->whenLoaded('offererEvaluation')),
            'applicant_evaluation' => new MatchEvaluationResource($this->whenLoaded('applicantEvaluation')),

            'created_at' => $this->textFormatDate($this->created_at, true),
            'updated_at' => $this->textFormatDate($this->updated_at, true),
        ];
    }
}
