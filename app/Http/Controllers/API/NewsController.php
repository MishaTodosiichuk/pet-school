<?php

namespace App\Http\Controllers\API;

use App\Actions\News\GetNewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\NewsItemResource;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    public function getNews(GetNewsAction $action): AnonymousResourceCollection
    {
        return $action->handle();
    }

    public function index(GetNewsAction $action, FilterRequest $request): AnonymousResourceCollection
    {
        return $action->allNews($request->validated());
    }

    public function show(GetNewsAction $action, string $slug): NewsItemResource
    {
        return $action->allNewsSingle($slug);
    }

    public function incrementViews(News $news, GetNewsAction $action): JsonResponse
    {
        $action->incrementViews($news);
        return response()->json(['status' => '200']);
    }
}
