<?php

namespace App\Http\Resources\Catalogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImpactMetricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'type'          => $this->type,
            'type_label'    => $this->type->label(),
            'color'         => $this->type->color(),
            'created_at'    => $this->createdAt,
        ];
    }
}
