<?php

namespace App\Http\Controllers\API;

use App\Actions\News\GetNewsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    public function getNews(GetNewsAction $action): AnonymousResourceCollection
    {
        return $action->handle();
    }
}
