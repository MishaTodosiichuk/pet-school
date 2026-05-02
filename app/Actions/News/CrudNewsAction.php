<?php

namespace App\Actions\News;

use App\Actions\BaseCrudAction;

use App\Models\News;
use App\Traits\ProcessesImagesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CrudNewsAction extends BaseCrudAction
{
    use ProcessesImagesTrait;

    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.news',
            modelClass: News::class,
            searchableColumns: ['id', 'title']
        );
    }

    protected function processData(array $data): array
    {
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        unset($data['images'], $data['images_uploads']);

        return $data;
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
