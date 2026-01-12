<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    public function createPhoto(UploadedFile $photo, PhotoStorageConfig $config)
    {
        $uuid = Str::uuid();
        $extension = $photo->getClientOriginalExtension();
        $filename = "{$config->usage}_{$uuid}.{$extension}";
        $filePath = $photo->storeAs($config->basePath, $filename, $config->disk);

        if (!$filePath) {
            throw new \RuntimeException('Failed to store photo');
        }

        return [
            'usage' => $config->usage,
            'mime_type' => $photo->getMimeType(),
            'size' => $photo->getSize(),
            'path' => $filePath,
            'filename' => $filename
        ];
    }

    public function storePhoto(Model $parent, array $photoData, PhotoStorageConfig $config): ?Photo
    {
        if (!method_exists($parent, $config->relation)) {
            throw new \InvalidArgumentException("Relation {$config->relation} does not exist on " . get_class($parent));
        }

        if (!isset($photoData['file']) || !($photoData['file'] instanceof UploadedFile)) {
            return null;
        }

        $photoMetaData = $this->createPhoto($photoData['file'], $config);
        $mergedData = array_merge(Arr::except($photoData, 'file'), $photoMetaData);
        $photo = $parent->{$config->relation}()->create($mergedData);
        return $photo;
    }

    public function storePhotos(Model $parent, array $photosData = [], PhotoStorageConfig $config): void
    {
        if (empty($photosData)) return;

        foreach ($photosData as $photoData) {
            if (isset($photoData['file']) && $photoData['file'] instanceof UploadedFile) {
                $this->storePhoto($parent, $photoData, $config);
            }
        }
    }

    public function updatePhoto(array $photoData, ?Photo $photo = null): ?Photo
    {

        if (!$photo && !isset($photoData['id'])) {
            return null;
        }

        if (!$photo) {
            $photo = Photo::find($photoData['id']);
            if (!$photo) {
                return null;
            }
        }

        $dataToUpdate = collect($photoData)
            ->except(['file', 'id', 'delete_photo', 'path'])
            ->filter(fn($value) => !is_null($value) && $value !== '')
            ->toArray();

        if (empty($dataToUpdate)) {
            return $photo;
        }

        $photo->update($dataToUpdate);
        $photo->fresh();
        return $photo;
    }

    public function replacePhoto(Photo $photo, UploadedFile $newPhoto, PhotoStorageConfig $config): Photo
    {
        $this->deletePhoto($photo, $config->disk, false);
        $newPhotoData = $this->createPhoto($newPhoto, $config);
        $photo->update($newPhotoData);
        $photo->fresh();
        return $photo;
    }

    public function upsertPhoto(Model $parent, array $photoData, PhotoStorageConfig $config): ?Photo
    {
        if (!isset($photoData['id'])) {
            return $this->storePhoto($parent, $photoData, $config);
        }

        $photo = $parent->{$config->relation}()->where('id', $photoData['id'])->firstOrFail();

        if (!$photo) {
            return $this->storePhoto($parent, $photoData, $config);
        }

        // delete photo
        if (isset($photoData['delete_photo']) && $photoData['delete_photo'] === true) {
            $this->deletePhoto($photo, $config->disk, true);
            return null;
        }

        if (isset($photoData['file']) && $photoData['file'] instanceof UploadedFile) {
            return $this->replacePhoto($photo, $photoData['file'], $config);
        }

        return $this->updatePhoto($photoData, $photo);
    }

    public function deletePhoto(Photo $photo, ?string $disk = null, bool $deleteRecord = true): void
    {
        $disk = $disk ?? 'private';
        if (Storage::disk($disk)->exists($photo->path)) {
            Storage::disk($disk)->delete($photo->path);
        }

        if ($deleteRecord) {
            $photo->delete();
        }
    }

    public function deletePhotos(Collection $photos, string $disk, bool $deleteRecords = true): void
    {
        foreach ($photos as $photo) {
            $this->deletePhoto($photo, $disk, $deleteRecords);
        }
    }

    public function syncPhotos(Model $parent, array $photosData, PhotoStorageConfig $config): void
    {
        DB::transaction(function () use ($parent, $photosData, $config) {
            $photoIdsInRequest = collect($photosData)
                ->filter(fn($photo) => isset($photo['id']))
                ->pluck('id')
                ->toArray();

            $existingPhotos = $parent->{$config->relation}()->get();
            $photosToDelete = $existingPhotos->whereNotIn('id', $photoIdsInRequest);

            $this->deletePhotos($photosToDelete, $config->disk);

            // foreach ($photosData as $photoData) {
            //     $this->upsertPhoto($parent, $photoData, $config);
            // }
            return collect($photosData)
                ->map(fn($photoData) => $this->upsertPhoto($parent, $photoData, $config))
                ->filter();
        });
    }
}
