<?php

namespace App\Http\Controllers\API;

use App\Actions\Menu\GetMenuAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController extends Controller
{
    public function getMenu(GetMenuAction $action): AnonymousResourceCollection
    {
        return $action->handle();
    }
}
