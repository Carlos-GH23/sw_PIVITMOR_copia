<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailTemplateResource extends JsonResource
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
            'key' => $this->key,
            'name' => $this->name,
            'subject' => $this->subject,
            'body' => $this->body,
            'available_variables' => $this->available_variables,
            'footer' => $this->footer,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
