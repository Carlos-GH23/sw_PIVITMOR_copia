<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\TechnologyServiceCategoryResource;
use App\Http\Resources\Catalogs\TechnologyServiceTypeResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\FacilityResource;
use App\Http\Resources\Institution\FacilityEquipmentResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\DateFormat;

class TechnologyServiceResource extends JsonResource
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
            'start_date' => $this->textFormatDate($this->start_date),
            'end_date' => $this->textFormatDate($this->end_date),
            'is_active' =>  $this->is_active,

            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'service_type_id' => $this->technology_service_type_id,
            'service_category_id' => $this->technology_service_category_id,
            'technology_service_status_id' => $this->technology_service_status_id,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'service_type' => new TechnologyServiceTypeResource($this->whenLoaded('technologyServiceType')),
            'service_category' => new TechnologyServiceCategoryResource($this->whenLoaded('technologyServiceCategory')),

            'user' => new UserResource($this->whenLoaded('user')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'facilities' => FacilityResource::collection($this->whenLoaded('facilities')),
            'equipments' => FacilityEquipmentResource::collection($this->whenLoaded('equipments')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'assessments' => AssessmentResource::collection($this->whenLoaded('assessments')),

            'created_at' => $this->textFormatDate($this->created_at, true),
            'status' => new TechnologyServiceStatusResource($this->whenLoaded('technologyServiceStatus')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
