<?php

namespace App\Actions\Page;

use App\Http\Resources\MenuWithPageInfoResource;
use App\Models\Menu;
class GetPageInfoBySlugAction
{
    public function getPageInfoBySlug(string $slug): array
    {
        $menu = Menu::query()
            ->where('slug', $slug)
            ->with(['page.blocks' => function($query) {
                $query->published()->orderBy('sort_order');
            }])

            ->firstOrFail();

        $pageBlocks = new MenuWithPageInfoResource($menu);

        return $pageBlocks->resolve();
    }
}
