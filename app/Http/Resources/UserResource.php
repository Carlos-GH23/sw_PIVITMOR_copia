<?php

namespace App\Http\Resources;

use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\InstitutionResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'roles'         => RoleResource::collection($this->whenLoaded('roles')),
            'photo'         => new FileResource($this->whenLoaded('photo')),
            'academic'      => new AcademicResource($this->whenLoaded('academic')),
            'institution'   => new InstitutionResource($this->whenLoaded('institution')),
            'is_active'     => $this->is_active,
            'created_at'    => $this->textFormatDate($this->created_at),
            'deleted_at'    => $this->deleted_at ? $this->textFormatDate($this->deleted_at) : null,
        ];
    }
}
