<?php

namespace App\Http\Controllers\Admin;

use App\Actions\News\CrudNewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreRequest;
use App\Http\Requests\News\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdatePublishRequest;
use App\Managers\IntegrateManagerNews;
use App\Models\News;

class NewsController extends Controller
{
    public function __construct(
        public CrudNewsAction       $crudMenuAction,
        public IntegrateManagerNews $integrateManagerNews
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerNews->getBreadcrumbs('index');
        $news = $this->crudMenuAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerNews->getTableConfig();

        return view('admin.pages.news.index', compact('news', 'tableConfig', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->integrateManagerNews->getBreadcrumbs('create');

        $formConfig = $this->integrateManagerNews->getFormConfig();

        return view('admin.pages.news.create', compact('breadcrumbs', 'formConfig'));
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
            ->with('success', 'Новину успішно створено!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $breadcrumbs = $this->integrateManagerNews->getBreadcrumbs('edit', $news);

        $formConfig = $this->integrateManagerNews->getFormConfig('patch', $news);

        return view('admin.pages.news.edit', compact('news', 'breadcrumbs', 'formConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, News $news)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $news = $this->crudMenuAction->update($news, $data);

        return $this->crudMenuAction->getViewAfterAction($redirectAfter, $news)
            ->with('success', 'Новину успішно оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->crudMenuAction->destroy($news);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новину успішно видалено!');
    }

    public function updatePublish(UpdatePublishRequest $request, News $news)
    {
        $data = $request->validated();
        $this->crudMenuAction->updatePublish($news, $data);
        return redirect()->route('admin.news.index')
            ->with('success', 'Новину успішно оновлено!');
    }
}
