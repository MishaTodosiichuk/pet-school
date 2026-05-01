<?php

namespace App\Managers;
use App\Actions\CrudActions;
use Illuminate\Database\Eloquent\Model;

abstract class BaseIntegrateManager
{
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

    abstract public function getFields(?Model $model = null): array;

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

        return [
            'action' => $method === 'POST'
                ? route("admin.{$module}.store")
                : route("admin.{$module}.update", $model?->id),
            'method' => $method,
            'actions' => $this->getFormActions(),
            'fields' => $this->getFields($model),
        ];
    }

    public function getTableConfig(): array
    {
        $module = $this->getModuleName();

        return [
            'columns' => $this->getTableColumns(),
            'routes' => [
                'create'  => route("admin.{$module}.create"),
                'edit'    => "admin.{$module}.edit",
                'destroy' => "admin.{$module}.destroy",
                'publish' => "/admin/{$module}/:id/publish",
            ],
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
