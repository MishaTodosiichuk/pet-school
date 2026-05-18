<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesDynamicBlocksTrait
{
    /**
     *
     * @param Model $model
     * @param array $data
     * @param string $relation
     * @param string $key
     * @param string $storageDir
     */
    protected function syncBlocksWithDelete(
        Model $model,
        array $data,
        string $relation = 'blocks',
        string $key = 'blocks',
        string $storageDir = 'page-blocks'
    ): void {
        $blocksData = $data[$key] ?? [];

        $oldBlocks = $model->{$relation}()->get();

        $submittedOldFiles = collect($blocksData)
            ->pluck('old_file')
            ->filter()
            ->toArray();

        foreach ($oldBlocks as $oldBlock) {
            if ($oldBlock->file) {
                $isBlockDeleted = !in_array($oldBlock->file, $submittedOldFiles);

                $hasNewFile = collect($blocksData)->contains(function ($b) use ($oldBlock) {
                    return isset($b['old_file']) && $b['old_file'] === $oldBlock->file && isset($b['file']);
                });

                if ($isBlockDeleted || $hasNewFile) {
                    if (Storage::disk('public')->exists($oldBlock->file)) {
                        Storage::disk('public')->delete($oldBlock->file);
                    }
                }
            }
        }

        $model->{$relation}()->delete();

        foreach ($blocksData as $index => $blockData) {
            $filePath = $blockData['old_file'] ?? null;

            if (isset($blockData['file']) && $blockData['file'] instanceof UploadedFile) {
                $filePath = $blockData['file']->store($storageDir, 'public');
            }

            $model->{$relation}()->create([
                'title'      => $blockData['title'] ?? null,
                'text'       => $blockData['text'] ?? null,
                'file'       => $filePath,
                'publish'    => (bool)($blockData['publish'] ?? false),
                'sort_order' => $blockData['sort_order'] ?? $index,
            ]);
        }
    }
}
