<?php

namespace App\Managers;

use App\Models\PhotoGallery;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerPhotoGallery extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'gallery';
    }

    public function getModuleTitle(): string
    {
        return 'Галереї';
    }

    public function getModuleIcon(): string
    {
        return 'fas fa-images';
    }

    public function getModelClass(): string
    {
        return PhotoGallery::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id'            => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'title'         => ['label' => 'Назва', 'class' => ''],
            'key'           => ['label' => 'Ключ', 'class' => ''],
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
            'key' => [
                'type' => 'string',
                'label' => 'Ключ',
                'placeholder' => 'Введіть ключ',
                'column' => 'side',
                'value' => old('key', $model?->key),
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
