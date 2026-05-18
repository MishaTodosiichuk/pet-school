<?php

namespace App\Managers;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerMenu extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'menus';
    }

    public function getModuleTitle(): string
    {
        return 'Меню';
    }

    public function getModuleIcon(): string
    {
        return 'fas fa-bars';
    }

    public function getModelClass(): string
    {
        return Menu::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id'      => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'title'   => ['label' => 'Назва', 'class' => ''],
            'publish' => ['label' => 'Опублікований', 'class' => 'text-center', 'type' => 'switch'],
        ];
    }

    public function getFields(?Model $model = null): array
    {
        $model = $model ?? new ($this->getModelClass());

        return [
            'title' => [
                'type' => 'string',
                'label' => 'Назва',
                'placeholder' => 'Введіть назву',
                'column' => 'main',
                'value' => old('title', $model?->title),
            ],

            'slug' => [
                'type' => 'string',
                'label' => 'Слаг',
                'placeholder' => 'Введіть слаг',
                'column' => 'main',
                'value' => old('slug', $model?->slug),
            ],

            'parent_id' => $this->getRelationField($model, 'parent', 'Батьківський елемент'),

            'publish' => [
                'type' => 'switch',
                'label' => 'Опублікувати',
                'column' => 'side',
                'value' => old('publish', $model ? $model->publish : true),
            ],
        ];
    }
    public function getDynamicFields(?Model $model = null): array
    {
        return [];
    }
}
