<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicBodyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'institution_id' => $this->institution_id,
            'consolidation_degree' => $this->whenLoaded('consolidationDegree'),
            'key' => $this->key,
            'review' => $this->review,
            'is_active' => $this->is_active,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'knowledge_lines' => KnowledgeLineResource::collection($this->whenLoaded('knowledgeLines')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'research_lines' => ResearchLineResource::collection($this->whenLoaded('researchLines')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
