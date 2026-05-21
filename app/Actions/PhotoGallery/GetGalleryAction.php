<?php

namespace App\Actions\PhotoGallery;

use App\Http\Resources\PhotoGalleryResource;
use App\Models\PhotoGallery;

class GetGalleryAction
{
    public function getGalleryByKey($key): PhotoGalleryResource
    {
        $gallery = PhotoGallery::query()
            ->published()
            ->byKey($key)
            ->with('images')
            ->firstOrFail();

        return new PhotoGalleryResource($gallery);
    }
}
