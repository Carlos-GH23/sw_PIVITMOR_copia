<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnologyCompanyResource extends JsonResource
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
            'num_employees' => $this->num_employees,
            'description' => $this->description,
            'origen_id' => $this->origen_id,
            'company_size_id' => $this->company_size_id,
            'innovation_type_id' => $this->innovation_type_id,
            'technology_level_id' => $this->technology_level_id,
            'market_reach_id' => $this->market_reach_id,
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'files' => FileResource::collection($this->whenLoaded('files')),
        ];
    }
}
