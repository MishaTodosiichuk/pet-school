<?php

namespace App\Actions\Image;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetImageAction
{
    public function getRandomImage(): AnonymousResourceCollection
    {
        $images = Image::query()->inRandomOrder()->limit(10)->get();

        return ImageResource::collection($images);
    }
}
