<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemMembershipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'academic_id' => $this->academic_id,
            'research_area_id' => $this->research_area_id,
            'sni_level_id' => $this->sni_level_id,
            'sni_level' => new SniLevelResource($this->whenLoaded('sniLevel')),
            'research_area' => new ResearchAreaResource($this->whenLoaded('researchArea')),
        ];
    }
}
