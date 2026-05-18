<?php

namespace App\Managers;
use App\Actions\CrudActions;
use App\Traits\Managers\HasRelationFieldsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

abstract class BaseIntegrateManager
{
    use HasRelationFieldsTrait;

    abstract public function getModuleName(): string;

    abstract public function getModuleTitle(): string;

    abstract public function getModuleIcon(): string;

    protected function getTableColumns(): array
    {
        return [
            'id'    => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'title' => ['label' => 'Назва', 'class' => ''],
        ];
    }
    protected function getRoutes(string $module): array
    {
        $getRoute = function($action) use ($module) {
            $name = "admin.{$module}.{$action}";
            return Route::has($name) ? $name : null;
        };
        $routes = [
            'index'   => Route::has("admin.{$module}.index") ? route("admin.{$module}.index") : null,
            'create'  => Route::has("admin.{$module}.create") ? route("admin.{$module}.create") : null,
            'show'    => $getRoute('show'),
            'edit'    => $getRoute('edit'),
            'destroy' => $getRoute('destroy'),
            'publish' => Route::has("admin.{$module}.publish") ? route("admin.{$module}.publish", [':id']) : null,
        ];

        return array_filter($routes);
    }

    abstract public function getFields(?Model $model = null): array;

    abstract public function getDynamicFields(?Model $model = null): array;

    public function getDynamicRelation(): ?string
    {
        return null;
    }

    public function getBreadcrumbs(string $action = 'index', ?Model $model = null): array
    {
        $module = $this->getModuleName();
        $moduleTitle = $this->getModuleTitle();

        $breadcrumbs = [
            [
                'title'  => 'Головна',
                'link'   => route('admin.home'),
                'active' => false,
            ],
        ];

        if ($action === 'index') {
            $breadcrumbs[] = [
                'title'  => $moduleTitle,
                'link'   => '#',
                'active' => true,
            ];
        } else {
            $breadcrumbs[] = [
                'title'  => $moduleTitle,
                'link'   => route("admin.{$module}.index"),
                'active' => false,
            ];
        }

        if ($action === 'create') {
            $breadcrumbs[] = [
                'title'  => 'Створення',
                'link'   => '#',
                'active' => true,
            ];
        }

        if ($action === 'edit') {
            $breadcrumbs[] = [
                'title'  => $model?->title,
                'link'   => '#',
                'active' => true,
            ];
        }
        if ($action === 'show') {
            $breadcrumbs[] = [
                'title'  => $model?->id,
                'link'   => '#',
                'active' => true,
            ];
        }

        return $breadcrumbs;
    }

    public function getFormActions(): array
    {
        $module = $this->getModuleName();

        return [
            CrudActions::SAVE => [
                'label' => 'Зберегти',
                'value' => CrudActions::SAVE
            ],
            CrudActions::SAVE_AND_CLOSE => [
                'label' => 'Зберегти та закрити',
                'value' => CrudActions::SAVE_AND_CLOSE
            ],
            CrudActions::SAVE_AND_NEW => [
                'label' => 'Зберегти та створити новий',
                'value' => CrudActions::SAVE_AND_NEW
            ],
            CrudActions::CLOSE => [
                'label' => 'Закрити',
                'value' => CrudActions::CLOSE,
                'link' => route("admin.{$module}.index")
            ],
        ];
    }

    public function getFormConfig(string $method = 'POST', ?Model $model = null): array
    {
        $module = $this->getModuleName();

        if ($method === 'POST') {
            $routeName = "admin.{$module}.store";
            $action = Route::has($routeName) ? route($routeName) : null;
        } else {
            $routeName = "admin.{$module}.update";
            $action = Route::has($routeName) ? route($routeName, $model?->id) : null;
        }

        return [
            'action' => $action,
            'method' => $method,
            'actions' => $this->getFormActions(),
            'fields' => $this->getFields($model),
            'dynamicFields' => $this->getDynamicFields($model),
            'dynamicRelation' => method_exists($this, 'getDynamicRelation')
                ? $this->getDynamicRelation()
                : null,
        ];
    }

    public function getTableConfig(): array
    {
        $module = $this->getModuleName();

        return [
            'columns' => $this->getTableColumns(),
            'routes' => $this->getRoutes($module),
            'search' => [
                'action' => route("admin.{$module}.index"),
            ]
        ];
    }

    public function getNavigationConfig(): array
    {
        $module = $this->getModuleName();

        return [
            'title' => $this->getModuleTitle(),
            'link'  => route("admin.{$module}.index"),
            'icon'  => $this->getModuleIcon(),
            'route_name' => "admin.{$module}.*"
        ];
    }
}
