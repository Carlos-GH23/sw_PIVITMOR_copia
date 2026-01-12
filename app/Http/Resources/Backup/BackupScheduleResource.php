<?php

namespace App\Http\Resources\Backup;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!$this->resource) {
            return [];
        }

        return [
            'id' => $this->id,
            'time' => $this->time ? substr($this->time, 0, 5) : null,
            'email_notification' => $this->email_notification,
            'backup_frequency_id' => $this->backup_frequency_id,
            'user_id' => $this->user_id,
            'backup_frequency' => new BackupFrequencyResource($this->whenLoaded('backupFrequency')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
