<?php

namespace App\Http\Resources\Catalogs;

use App\Http\Resources\EconomicSocialSectorResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EconomicSectorResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'level'       => $this->level,
            'parent_id'   => $this->parent_id,

            // Conditionally load the parent resource only if the relationship has been eagerly loaded.
            // This prevents N+1 query issues and allows for a nested structure.
            'parent'      => new self($this->whenLoaded('parent')),

            // Conditionally load the children resources as a collection, formatted recursively.
            // This is useful for displaying the full hierarchy.
            'children'    => self::collection($this->whenLoaded('children')),


            'economic_social_sector_id' => $this->economic_social_sector_id,
            'economic_social_sector'    => new EconomicSocialSectorResource($this->whenLoaded('economicSocialSector')),

            'created_at'  => $this->textFormatDate($this->created_at),
        ];
    }
}
