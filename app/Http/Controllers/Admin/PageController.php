<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Page\CrudPageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StoreRequest;
use App\Http\Requests\Page\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Managers\IntegrateManagerPage;
use App\Models\Page;

class PageController extends Controller
{
    public function __construct(
        public CrudPageAction       $crudPageAction,
        public IntegrateManagerPage $integrateManagerPage
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerPage->getBreadcrumbs('index');
        $pages = $this->crudPageAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerPage->getTableConfig();

        return view('admin.pages.page.index', compact('pages', 'tableConfig', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->integrateManagerPage->getBreadcrumbs('create');

        $formConfig = $this->integrateManagerPage->getFormConfig();

        return view('admin.pages.page.create', compact('breadcrumbs', 'formConfig'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $page = $this->crudPageAction->store($data);

        return $this->crudPageAction->getViewAfterAction($redirectAfter, $page)
            ->with('success', 'Сторінку успішно створено!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $page->load('blocks');
        $breadcrumbs = $this->integrateManagerPage->getBreadcrumbs('edit', $page);

        $formConfig = $this->integrateManagerPage->getFormConfig('patch', $page);

        return view('admin.pages.page.edit', [
            'model' => $page,
            'page' => $page,
            'breadcrumbs' => $breadcrumbs,
            'formConfig' => $formConfig,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Page $page)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $page = $this->crudPageAction->update($page, $data);

        return $this->crudPageAction->getViewAfterAction($redirectAfter, $page)
            ->with('success', 'Сторінку успішно оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $this->crudPageAction->destroy($page);

        return redirect()->route('admin.page.index')
            ->with('success', 'Сторінку успішно видалено!');
    }
}
