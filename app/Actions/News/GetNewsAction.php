<?php

namespace App\Actions\News;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetNewsAction
{
    public function handle(): AnonymousResourceCollection
    {
        $news = News::query()
            ->published()
            ->paginate(10);

        return NewsResource::collection($news);
    }
}
