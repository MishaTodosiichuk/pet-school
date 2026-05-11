<?php

namespace App\Http\Controllers\API;

use App\Actions\PhotoGallery\GetGalleryAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoGalleryResource;

class PhotoGalleryController extends Controller
{
    public function getMainGallery(GetGalleryAction $action): PhotoGalleryResource
    {
        return $action->getGalleryByKey('main_slider');
    }
    public function getPageGallery(GetGalleryAction $action): PhotoGalleryResource
    {
        return $action->getGalleryByKey('page_gallery');
    }
}
