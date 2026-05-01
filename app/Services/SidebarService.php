<?php

namespace App\Services;

use Illuminate\View\View;

class SidebarService
{
    public function compose(View $view): void
    {
        $modules = config('admin.modules', []);
        $navigation = [];
        foreach ($modules as $managerClass) {
            $manager = app($managerClass);
            $navigation[] = $manager->getNavigationConfig();
        }

        $view->with('sidebarMenu', $navigation);
    }
}
