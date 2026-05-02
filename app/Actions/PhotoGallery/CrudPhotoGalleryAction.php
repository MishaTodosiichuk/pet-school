<?php

namespace App\Actions\PhotoGallery;

use App\Actions\BaseCrudAction;

use App\Models\PhotoGallery;
use App\Traits\ProcessesImagesTrait;
use Illuminate\Database\Eloquent\Model;

class CrudPhotoGalleryAction extends BaseCrudAction
{
    use ProcessesImagesTrait;

    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.gallery',
            modelClass: PhotoGallery::class,
            searchableColumns: ['id', 'key', 'title']
        );
    }

    protected function afterStore(Model $model, array $data): void
    {
        $this->processImages($model, $data);
    }

    protected function afterUpdate(Model $model, array $data): void
    {
        $this->processImages($model, $data);
    }
}
