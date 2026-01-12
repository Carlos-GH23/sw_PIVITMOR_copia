<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Catalogs\FacilityTypeResource;
use App\Http\Resources\EntityResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Http\Resources\Institution\FacilityEquipmentResource;
use App\Http\Resources\Institution\CertificationResource;

class FacilityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'facility_type_id' => $this->facility_type_id,
            'department_id'    => $this->department_id,
            'is_active'   => $this->is_active,
            'facility_type'    => new FacilityTypeResource($this->whenLoaded('facilityType')),
            'department'       => new DepartmentResource($this->whenLoaded('department')),
            'equipments'       => FacilityEquipmentResource::collection($this->whenLoaded('equipments')),
            'certifications'   => CertificationResource::collection($this->whenLoaded('certifications')),
            'photos'      => PhotoResource::collection($this->whenLoaded('photos')),
            'files'       => FileResource::collection($this->whenLoaded('files')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
