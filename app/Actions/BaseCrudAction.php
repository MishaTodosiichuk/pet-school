<?php

namespace App\Actions;

use App\Contracts\BaseCrudContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;

class BaseCrudAction implements BaseCrudContract
{
    protected string $routePrefix;
    protected string $modelClass;
    protected array $searchableColumns;

    public function __construct(string $routePrefix, string $modelClass, array $searchableColumns)
    {
        $this->routePrefix = $routePrefix;
        $this->modelClass = $modelClass;
        $this->searchableColumns = $searchableColumns;
    }

    public function index(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = (new $this->modelClass)->newQuery();

        if (!empty($search)) {
            $query = $this->search($search, $query->getModel());
        } elseif (method_exists($query->getModel(), 'defaultOrder')) {
            $query->defaultOrder();
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function store(array $data): Model
    {
        $originalData = $data;

        $data = $this->processData($data);

        $model = (new $this->modelClass)->newQuery()->create($data);

        $this->afterStore($model, $originalData);

        return $model;
    }

    public function update(Model $model, array $data): Model
    {
        $originalData = $data;

        $data = $this->processData($data);

        $model->update($data);

        $this->afterUpdate($model, $originalData);

        return $model->fresh();
    }

    public function updatePublish(Model $model, array $data): void
    {
        $model->update($data);
    }

    public function destroy(Model $model): void
    {
        $model->delete();
    }

    public function search(string $search, Model $model): Builder
    {
        return $model->newQuery()->where(function (Builder $query) use ($search) {
            foreach ($this->searchableColumns as $column) {
                $query->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
    }

    public function getViewAfterAction(?string $action, Model $model): RedirectResponse
    {
        return match ($action) {
            CrudActions::SAVE           => redirect()->route("{$this->routePrefix}.edit", $model->id),
            CrudActions::SAVE_AND_NEW   => redirect()->route("{$this->routePrefix}.create"),
            CrudActions::SAVE_AND_CLOSE => redirect()->route("{$this->routePrefix}.index"),
            default                     => redirect()->route("{$this->routePrefix}.index"),
        };
    }

    protected function processData(array $data): array
    {
        return $data;
    }

    protected function afterStore(Model $model, array $data): void
    {
    }

    protected function afterUpdate(Model $model, array $data): void
    {
    }
}
