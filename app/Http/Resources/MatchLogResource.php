<?php

namespace App\Http\Resources;

use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchLogResource extends JsonResource
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
            'action' => $this->action->value,
            'action_label' => $this->action->label(),
            'description' => $this->description,
            'capability_requirement_match_id' => $this->capability_requirement_match_id,
            'user_id' => $this->user_id,

            'capability_requirement_match' => new CapabilityRequirementMatchResource($this->whenLoaded('capabilityRequirementMatch')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->textFormatDate($this->created_at, true),
        ];
    }
}
