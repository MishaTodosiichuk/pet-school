<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Menu\CrudMenuAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\SearchRequest;
use App\Http\Requests\Menu\StoreRequest;
use App\Http\Requests\Menu\UpdatePublishRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Managers\IntegrateManagerMenu;
use App\Models\Menu;

class MenuController extends Controller
{
    public function __construct(
        public CrudMenuAction       $crudMenuAction,
        public IntegrateManagerMenu $integrateManagerMenu
    )
    {
    }

    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('index');
        $menus = $this->crudMenuAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerMenu->getTableConfig();

        return view('admin.pages.menu.index', compact('menus', 'tableConfig', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('create');

        $formConfig = $this->integrateManagerMenu->getFormConfig();

        return view('admin.pages.menu.create', compact('breadcrumbs', 'formConfig'));
    }

    public function store(StoreRequest $request)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();

        $menu = $this->crudMenuAction->store($data);

        return $this->crudMenuAction->getViewAfterAction($redirectAfter, $menu)
            ->with('success', 'Пункт меню успішно створено!');
    }

    public function edit(Menu $menu)
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('edit', $menu);

        $formConfig = $this->integrateManagerMenu->getFormConfig('patch', $menu);

        return view('admin.pages.menu.edit', compact('menu', 'breadcrumbs', 'formConfig'));
    }

    public function update(UpdateRequest $request, Menu $menu)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $menu = $this->crudMenuAction->update($menu, $data);

        return $this->crudMenuAction->getViewAfterAction($redirectAfter, $menu)
            ->with('success', 'Пункт меню успішно оновлено!');
    }

    public function destroy(Menu $menu)
    {
        $this->crudMenuAction->destroy($menu);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Пункт меню успішно видалено!');
    }

    public function updatePublish(UpdatePublishRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $this->crudMenuAction->updatePublish($menu, $data);
        return redirect()->route('admin.menus.index')
            ->with('success', 'Пункт меню успішно оновлено!');
    }
}
