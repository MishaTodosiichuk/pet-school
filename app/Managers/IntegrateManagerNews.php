<?php

namespace App\Managers;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerNews extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'news';
    }

    public function getModuleTitle(): string
    {
        return 'Новини';
    }

    public function getModuleIcon(): string
    {
        return 'far fa-newspaper';
    }

    public function getModelClass(): string
    {
        return News::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id'            => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'title'         => ['label' => 'Назва', 'class' => ''],
            'description'   => ['label' => 'Опис', 'class' => ''],
            'publish'       => ['label' => 'Опублікований', 'class' => 'text-center', 'type' => 'switch'],
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
            'description' => [
                'type' => 'text',
                'label' => 'Опис',
                'placeholder' => 'Введіть опис',
                'column' => 'main',
                'value' => old('description', $model?->description),
            ],
            'publish' => [
                'type' => 'switch',
                'label' => 'Опублікувати',
                'column' => 'side',
                'value' => old('publish', $model ? $model->publish : true),
            ],
            'images' => $this->getRelationField($model, 'images', 'Галерея', 'alt', 'images','main'),
        ];
    }
}
