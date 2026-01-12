<?php

namespace App\Http\Resources\Catalogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnologyServiceTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'category_id' => $this->category_id,
            'name'        => $this->name,
            'description' => $this->description,

            'category'    => new TechnologyServiceCategoryResource($this->whenLoaded('category')),
        ];
    }
}
