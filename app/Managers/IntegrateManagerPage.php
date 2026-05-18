<?php

namespace App\Managers;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerPage extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'page';
    }

    public function getModuleTitle(): string
    {
        return 'Інформація на сторінках';
    }

    public function getModuleIcon(): string
    {
        return 'fas fa-info-circle';
    }

    public function getModelClass(): string
    {
        return Page::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id' => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'title' => ['label' => 'Назва', 'class' => ''],
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
                'column' => 'full',
                'value' => old('title', $model?->title),
            ],
        ];
    }

    public function getDynamicFields(?Model $model = null): array
    {
        return [
            'title' => [
                'type' => 'string',
                'label' => 'Назва',
                'placeholder' => 'Введіть назву',
                'column' => 'main',
                'value' => null,
            ],

            'text' => [
                'type' => 'text',
                'label' => 'Опис',
                'placeholder' => 'Введіть опис',
                'column' => 'main',
                'value' => null,
            ],

            'file' => [
                'type' => 'documents',
                'label' => 'Файли',
                'placeholder' => 'Оберіть файл',
                'column' => 'main',
                'value' => null,
            ],

            'publish' => [
                'type' => 'switch',
                'label' => 'Опублікувати',
                'column' => 'side',
                'value' => true,
            ],
        ];
    }
    public function getDynamicRelation(): ?string
    {
        return 'blocks';
    }
}
