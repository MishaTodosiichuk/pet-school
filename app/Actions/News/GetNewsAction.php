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
    public function allNews(array $filters = []): AnonymousResourceCollection
    {
        $news = News::query()
            ->published()
            ->with('images')
            ->when(
                !empty($filters['start-date']) && !empty($filters['end-date']),
                function ($query) use ($filters) {
                    $start = Carbon::parse($filters['start-date'])->startOfDay();
                    $end = Carbon::parse($filters['end-date'])->endOfDay();

                    $query->whereBetween('created_at', [$start, $end]);
                }
            )
            ->latest()
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

    public function incrementViews(News $news): void
    {
        $key = 'viewed_news_' . $news->id . '_' . request()->ip();

        if (!Cache::has($key)) {
            $news->increment('views_count');

            Cache::put($key, true, 1440);
        }
    }
}
