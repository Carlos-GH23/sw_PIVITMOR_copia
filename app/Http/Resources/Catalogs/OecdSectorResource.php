<?php

namespace App\Http\Resources\Catalogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EconomicSocialSectorResource;

class OecdSectorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'parent_id'  => $this->parent_id,
            'parent'     => $this->when($this->parent, fn() => [
                'id'    => $this->parent->id,
                'name'  => $this->parent->name,
                'parent' => $this->when($this->parent->parent, fn() => [
                    'id'    => $this->parent->parent->id,
                    'name'  => $this->parent->parent->name,
                ]),
            ]),
            'children'   => OecdSectorResource::collection($this->whenLoaded('children')),
            'level'      => $this->level,
            'economic_social_sector_id' => $this->economic_social_sector_id,
            'economic_social_sector'    => new EconomicSocialSectorResource($this->whenLoaded('economicSocialSector')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
