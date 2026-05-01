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
        $options = Menu::query()
            ->when($model?->exists, function ($query) use ($model) {
                return $query->where('id', '!=', $model->id);
            })
            ->select('id', 'title', 'parent_id')
            ->get();

        return [
            'title' => [
                'type' => 'text',
                'label' => 'Назва',
                'placeholder' => 'Введіть назву',
                'column' => 'main',
                'value' => old('title', $model?->title),
            ],
            'slug' => [
                'type' => 'text',
                'label' => 'Слаг',
                'placeholder' => 'Введіть слаг',
                'column' => 'main',
                'value' => old('slug', $model?->slug),
            ],
            'parent_id' => [
                'type' => 'select',
                'label' => 'Батьківський елемент',
                'placeholder' => 'Оберіть батьківський компонент',
                'column' => 'side',
                'options' => $options,
                'value' => old('parent_id', $model?->parent_id),
            ],
            'publish' => [
                'type' => 'switch',
                'label' => 'Опублікувати',
                'column' => 'side',
                'value' => old('publish', $model ? $model->publish : true),
            ],
        ];
    }
}
