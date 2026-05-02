<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Menu\CrudMenuAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\StoreRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdatePublishRequest;
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
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('index');
        $menus = $this->crudMenuAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerMenu->getTableConfig();

        return view('admin.pages.menu.index', compact('menus', 'tableConfig', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('create');

        $formConfig = $this->integrateManagerMenu->getFormConfig();

        return view('admin.pages.menu.create', compact('breadcrumbs', 'formConfig'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();

        $menu = $this->crudMenuAction->store($data);

        return $this->crudMenuAction->getViewAfterAction($redirectAfter, $menu)
            ->with('success', 'Пункт меню успішно створено!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $breadcrumbs = $this->integrateManagerMenu->getBreadcrumbs('edit', $menu);

        $formConfig = $this->integrateManagerMenu->getFormConfig('patch', $menu);

        return view('admin.pages.menu.edit', compact('menu', 'breadcrumbs', 'formConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Menu $menu)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $menu = $this->crudMenuAction->update($menu, $data);

        return $this->crudMenuAction->getViewAfterAction($redirectAfter, $menu)
            ->with('success', 'Пункт меню успішно оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
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
