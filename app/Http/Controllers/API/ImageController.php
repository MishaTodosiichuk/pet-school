<?php

namespace App\Http\Controllers\API;

use App\Actions\Image\GetImageAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ImageController extends Controller
{
    public function getRandomImage(GetImageAction $action): AnonymousResourceCollection
    {
        return $action->getRandomImage();
    }
}
