<?php

namespace App\Http\Resources\Backup;

use App\Http\Resources\UserResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupLogResource extends JsonResource
{
    use DateFormat;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'backup_action_id' => $this->backup_action_id,
            'backup_status_id' => $this->backup_status_id,
            'created_at' => $this->textFormatDate($this->created_at, 'true'),
            'user' => new UserResource($this->whenLoaded('user')),
            'backup_action' => new BackupActionResource($this->whenLoaded('backupAction')),
            'backup_status' => new BackupStatusResource($this->whenLoaded('backupStatus')),
        ];
    }
}
