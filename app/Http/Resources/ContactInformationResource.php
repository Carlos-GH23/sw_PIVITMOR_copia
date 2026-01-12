<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInformationResource extends JsonResource
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
            'email' => $this->email,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'opening_time' => $this->opening_time ? substr($this->opening_time, 0, 5) : null,
            'closing_time' => $this->closing_time ? substr($this->closing_time, 0, 5) : null,

            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
        ];
    }
}
