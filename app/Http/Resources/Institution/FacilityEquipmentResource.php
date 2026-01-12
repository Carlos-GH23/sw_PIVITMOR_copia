<?php

namespace App\Http\Resources\Institution;

use App\Http\Resources\Catalogs\EquipmentTypeResource;
use App\Http\Resources\EntityResource;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Traits\DateFormat;
use App\Http\Resources\Institution\FacilityResource;

class FacilityEquipmentResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'equipment_type_id' => $this->equipment_type_id,
            'responsible_id' => $this->responsible_id,
            'facility_id' => $this->facility_id,
            'department_id' => $this->department_id,
            'equipmentType' => new EquipmentTypeResource($this->whenLoaded('equipmentType')),
            'responsible' => new AcademicResource($this->whenLoaded('responsible')),
            'facility' => new FacilityResource($this->whenLoaded('facility')),
            'status' => $this->status,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
