<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchLineResource extends JsonResource
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
            'description' => $this->description,
            'is_active' => $this->is_active,
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
