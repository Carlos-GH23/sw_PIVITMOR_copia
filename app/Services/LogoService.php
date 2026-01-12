<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LogoService
{
    public function process(Model $parent, array $data, string $directory): void
    {
        if (!array_key_exists('logo', $data)) {
            return;
        }

        $logoData = $data['logo'];

        if ($logoData instanceof UploadedFile) {
            $this->syncLogo($parent, $logoData, $directory);
        } 
        
        else {
            $this->deleteLogo($parent);
        }
    }

    public function syncLogo(Model $parent, ?UploadedFile $logoFile, string $directory = 'logos'): void
    {
        if (!$logoFile) {
            return;
        }

        if ($parent->photo) {
            Storage::disk('public')->delete($parent->photo->path);
        }
        
        $path = $logoFile->store($directory, 'public');

        $parent->photo()->updateOrCreate(
            ['photoable_id' => $parent->id, 'photoable_type' => get_class($parent)],
            [
                'usage'     => 'logo',
                'filename'  => $logoFile->getClientOriginalName(),
                'path'      => $path,
                'mime_type' => $logoFile->getClientMimeType(),
                'size'      => $logoFile->getSize(),
            ]
        );
    }

    public function deleteLogo(Model $parent): void
    {
        if ($parent->photo) {
            Storage::disk('public')->delete($parent->photo->path);
            $parent->photo()->delete();
        }
    }
}