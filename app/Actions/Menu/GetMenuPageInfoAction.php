<?php

namespace App\Actions\Menu;

use App\Models\Menu;

class GetMenuPageInfoAction
{
    public function handle(Menu $menu): array
    {
        $page = $menu->page()->first();
        if ($page === null)
        {
            return [];
        }
        return [
            'label' => 'Перейти на інформаційну сторінку',
            'link' => route('admin.page.edit', $page->id)
        ];
    }
}
