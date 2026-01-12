<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\IntellectualPropertyResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\TechnologyLevelResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequirementResource extends JsonResource
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

            'title' => $this->title,
            'technical_description' => $this->technical_description,
            'need_statement' => $this->need_statement,
            'potential_applications' => $this->potential_applications,
            'start_date' => $this->textFormatDate($this->start_date),
            'end_date' => $this->textFormatDate($this->end_date),
            'is_active' =>  $this->is_active,
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'requirement_status_id' => $this->requirement_status_id,
            'intellectual_property_id' => $this->intellectual_property_id,
            'technology_level_id' => $this->technology_level_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'requirement_status' => new RequirementStatusResource($this->whenLoaded('requirementStatus')),
            'intellectual_property' => new IntellectualPropertyResource($this->whenLoaded('intellectualProperty')),
            'technology_level' => new TechnologyLevelResource($this->whenLoaded('technologyLevel')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'assessments' => AssessmentResource::collection($this->whenLoaded('assessments')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
            'created_at' => $this->textFormatDate($this->created_at, true),
        ];
    }
}
