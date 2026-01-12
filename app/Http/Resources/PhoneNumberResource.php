<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneNumberResource extends JsonResource
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
            'number' => $this->number,
            'dial_code' => $this->dial_code,
            'type' => $this->type,
            'phoneable_id' => $this->phoneable_id,
            'phoneable_type' => $this->phoneable_type,
        ];
    }
}
