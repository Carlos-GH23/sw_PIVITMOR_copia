<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\IntellectualPropertyResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\TechnologyLevelResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CapabilityResource extends JsonResource
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
            'problem_statement' => $this->problem_statement,
            'potential_applications' => $this->potential_applications,
            'start_date' => $this->textFormatDate($this->start_date),
            'end_date' => $this->textFormatDate($this->end_date),
            'is_active' =>  $this->is_active,
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'capability_status_id' => $this->capability_status_id,
            'intellectual_property_id' => $this->intellectual_property_id,
            'technology_level_id' => $this->technology_level_id,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'technology_level' => new TechnologyLevelResource($this->whenLoaded('technologyLevel')),
            'intellectual_property' => new IntellectualPropertyResource($this->whenLoaded('intellectualProperty')),
            'status' => new CapabilityStatusResource($this->whenLoaded('capabilityStatus')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords', $this->keywords)),
            'assessments' => AssessmentResource::collection($this->whenLoaded('assessments')),
            'user' => new UserResource($this->whenLoaded('user')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
