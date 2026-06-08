<?php

namespace App\Actions\News;

use App\Http\Resources\NewsItemResource;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class GetNewsAction
{
    public function handle(): AnonymousResourceCollection
    {
        $news = News::query()
            ->published()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return NewsResource::collection($news);
    }
    public function allNewsSingle(string $slug): NewsItemResource
    {
        $news = News::query()
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        return new NewsItemResource($news);
    }

    public function allNews(array $request): AnonymousResourceCollection
    {
        $news = News::query()
            ->when(!empty($request['start-date']) && !empty($request['end-date']), function ($query) use ($request) {
                $start = Carbon::parse($request['start-date'])->startOfDay();
                $end = Carbon::parse($request['end-date'])->endOfDay();

                $query->whereBetween('created_at', [$start, $end]);
            })
            ->latest()
            ->published()
            ->paginate(10);

        return NewsResource::collection($news);
    }

    public function incrementViews(News $news): void
    {
        $key = 'viewed_news_' . $news->id . '_' . request()->ip();

        if (!Cache::has($key)) {
            $news->increment('views_count');

            Cache::put($key, true, 1440);
        }
    }
}
