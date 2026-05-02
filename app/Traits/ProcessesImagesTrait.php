<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ProcessesImagesTrait
{
    protected function processImages(Model $model, array $data, ?string $directoryName = null): void
    {
        $files = $data['images_uploads'] ?? [];
        $existingIds = $data['images'] ?? [];

        if ($existingIds instanceof Collection) {
            $existingIds = $existingIds->pluck('id')->toArray();
        } else {
            $existingIds = (array) $existingIds;
        }

        $directory = $directoryName ?: $model->getTable();
        $uploadedIds = [];

        foreach ($files as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = "uploads/{$directory}/{$model->id}";
            $fullPath = "{$path}/{$filename}";

            Storage::disk('public')->putFileAs($path, $file, $filename);

            $image = Image::query()->create([
                'url' => Storage::url($fullPath),
                'alt' => $model->title ?? $model->name ?? $filename,
                'disk' => 'public',
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            $uploadedIds[] = $image->id;
        }

        if (method_exists($model, 'images')) {
            $model->images()->sync(array_merge($existingIds, $uploadedIds));
        }
    }
}
