<?php

namespace App\Http\Controllers\Admin;

use App\Actions\PhotoGallery\CrudPhotoGalleryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhotoGallery\StoreRequest;
use App\Http\Requests\PhotoGallery\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdatePublishRequest;
use App\Managers\IntegrateManagerPhotoGallery;
use App\Models\PhotoGallery;

class PhotoGalleryController extends Controller
{
    public function __construct(
        public CrudPhotoGalleryAction $crudPhotoGalleryAction,
        public IntegrateManagerPhotoGallery $integrateManagerPhotoGallery
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerPhotoGallery->getBreadcrumbs('index');
        $gallery = $this->crudPhotoGalleryAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerPhotoGallery->getTableConfig();

        return view('admin.pages.gallery.index', compact('gallery', 'tableConfig', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = $this->integrateManagerPhotoGallery->getBreadcrumbs('create');

        $formConfig = $this->integrateManagerPhotoGallery->getFormConfig();

        return view('admin.pages.gallery.create', compact('breadcrumbs', 'formConfig'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();

        $menu = $this->crudPhotoGalleryAction->store($data);

        return $this->crudPhotoGalleryAction->getViewAfterAction($redirectAfter, $menu)
            ->with('success', 'Галерею успішно створено!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoGallery $gallery)
    {
        $breadcrumbs = $this->integrateManagerPhotoGallery->getBreadcrumbs('edit', $gallery);

        $formConfig = $this->integrateManagerPhotoGallery->getFormConfig('patch', $gallery);

        return view('admin.pages.gallery.edit', compact('gallery', 'breadcrumbs', 'formConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, PhotoGallery $gallery)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $gallery = $this->crudPhotoGalleryAction->update($gallery, $data);

        return $this->crudPhotoGalleryAction->getViewAfterAction($redirectAfter, $gallery)
            ->with('success', 'Галерею успішно оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoGallery $gallery)
    {
        $this->crudPhotoGalleryAction->destroy($gallery);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Галерею успішно видалено!');
    }

    public function updatePublish(UpdatePublishRequest $request, PhotoGallery $gallery)
    {
        $data = $request->validated();
        $this->crudPhotoGalleryAction->updatePublish($gallery, $data);
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Галерею успішно оновлено!');
    }
}
