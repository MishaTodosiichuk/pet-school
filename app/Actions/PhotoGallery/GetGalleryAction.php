<?php

namespace App\Actions\PhotoGallery;

use App\Http\Resources\PhotoGalleryResource;
use App\Models\PhotoGallery;

class GetGalleryAction
{
    public function getMainGallery(): PhotoGalleryResource
    {
        $gallery = PhotoGallery::query()
            ->published()
            ->byKey('main-gallery')
            ->with('images')
            ->first();

        return new PhotoGalleryResource($gallery);
    }
}
