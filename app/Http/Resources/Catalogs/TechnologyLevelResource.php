<?php

namespace App\Http\Resources\Catalogs;

use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnologyLevelResource extends JsonResource
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
            'id'         => $this->id,
            'level'      => $this->level,
            'name'       => $this->name,
            'created_at'  => $this->textFormatDate($this->created_at),
        ];
    }
}