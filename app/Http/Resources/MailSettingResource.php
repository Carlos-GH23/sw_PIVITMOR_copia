<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MailSettingResource extends JsonResource
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
            'username' => $this->username,
            'from_address' => $this->from_address,
            'from_name' => $this->from_name,
            'host' => $this->host,
            'port' => $this->port,
            'trust' => $this->trust,
            'protocol' => $this->protocol,
            'encoding' => $this->encoding,
            'debug' => $this->debug,
            'auth_enabled' => $this->auth_enabled,
            'encryption' => $this->encryption,
            'starttls_enabled' => $this->starttls_enabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
