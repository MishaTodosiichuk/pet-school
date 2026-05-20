<?php

namespace App\Http\Controllers\API;

use App\Actions\Page\GetPageInfoBySlugAction;

class PageController
{
    public function getPageInfoBySlug(string $slug, GetPageInfoBySlugAction $action): array
    {
        return $action->getPageInfoBySlug($slug);
    }
}
