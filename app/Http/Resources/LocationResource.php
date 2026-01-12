<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'neighborhood_id' => $this->neighborhood_id,
            'street'          => $this->street,
            'exterior_number' => $this->exterior_number,
            'interior_number' => $this->interior_number,
            'longitude'       => $this->longitude,
            'latitude'        => $this->latitude,
            'full_address'    => $this->whenAppended('full_address', $this->fullAddress),
            'neighborhood'    => new NeighborhoodResource($this->whenLoaded('neighborhood')),
        ];
    }
}
