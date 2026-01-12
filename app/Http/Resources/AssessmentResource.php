<?php

namespace App\Http\Resources;

use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentResource extends JsonResource
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
            'id' => $this->id,
            'body' => $this->body,
            'is_visible' => $this->is_visible,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),

            'created_at' => $this->textFormatDate($this->created_at, true),
            'updated_at' => $this->textFormatDate($this->updated_at, true),
            'deleted_at' => $this->textFormatDate($this->deleted_at, true),
        ];
    }
}
