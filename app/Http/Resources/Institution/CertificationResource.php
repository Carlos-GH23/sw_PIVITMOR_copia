<?php

namespace App\Http\Resources\Institution;

use App\Http\Resources\EntityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FileResource;
use App\Models\Academic;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;

class CertificationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'description'          => $this->description,
            'certification_type_id' => $this->certification_type_id,
            'department_id'        => $this->department_id,
            'resource_type_id'     => $this->resource_type_id,
            'certifying_entity'    => $this->certifying_entity,
            'certified_resource_id' => $this->certified_resource_id,
            'certified_resource_type' => $this->certified_resource_type,
            'is_active'            => $this->is_active,
            'files'                => FileResource::collection($this->whenLoaded('files')),
            'resource_type'        => new ResourceTypeResource($this->whenLoaded('resourceType')),
            'certification_type'   => new CertificationTypeResource($this->whenLoaded('certificationType')),
            'certified_resource'   => $this->whenLoaded('certifiedResource', function () {
                return match (get_class($this->certifiedResource)) {
                    Facility::class => new FacilityResource($this->certifiedResource),
                    Academic::class => new AcademicResource($this->certifiedResource),
                    FacilityEquipment::class => new FacilityEquipmentResource($this->certifiedResource),
                };
            }),
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,

            'department' => new DepartmentResource($this->whenLoaded('department')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
