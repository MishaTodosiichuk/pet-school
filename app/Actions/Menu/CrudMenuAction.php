<?php

namespace App\Actions\Menu;

use App\Actions\BaseCrudAction;
use App\Models\Menu;
use Illuminate\Support\Str;

class CrudMenuAction extends BaseCrudAction
{
    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.menus',
            modelClass: Menu::class,
            searchableColumns: ['id', 'title']
        );
    }

    protected function processData(array $data): array
    {
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }
}
