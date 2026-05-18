<?php

namespace App\Actions\Page;

use App\Actions\BaseCrudAction;

use App\Models\Page;
use App\Traits\HandlesDynamicBlocksTrait;
use App\Traits\ProcessesImagesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class CrudPageAction extends BaseCrudAction
{
    use HandlesDynamicBlocksTrait;

    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.page',
            modelClass: Page::class,
            searchableColumns: ['id', 'title']
        );
    }

    protected function processData(array $data): array
    {
        unset($data['blocks']);

        return $data;
    }

    protected function afterStore(Model $model, array $data): void
    {
        $this->syncBlocksWithDelete($model, $data);
    }

    protected function afterUpdate(Model $model, array $data): void
    {
        $this->syncBlocksWithDelete($model, $data);
    }
}
