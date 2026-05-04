<?php

namespace App\Actions\Menu;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetMenuAction
{
    public function handle(): AnonymousResourceCollection
    {
        $menus = Menu::query()
            ->published()
            ->whereNull('parent_id')
            ->with([
                'children' => fn ($query) => $query->published()
            ])
            ->get();

        return MenuResource::collection($menus);
    }
}
