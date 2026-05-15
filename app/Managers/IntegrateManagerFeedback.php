<?php

namespace App\Managers;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerFeedback extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'feedback';
    }

    public function getModuleTitle(): string
    {
        return 'Повідомлення';
    }

    public function getModuleIcon(): string
    {
        return 'fas fa-envelope-open';
    }

    public function getModelClass(): string
    {
        return Feedback::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id'          => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'name'        => ['label' => 'ПІБ', 'class' => ''],
            'email'       => ['label' => 'Електронна адреса', 'class' => ''],
        ];
    }

    public function getFields(?Model $model = null): array
    {
        $model = $model ?? new ($this->getModelClass());

        return [
            'name' => [
                'type' => 'string',
                'label' => 'ПІБ',
                'placeholder' => 'Введіть код',
                'column' => 'full',
                'value' => old('name', $model?->name),
            ],
            'email' => [
                'type' => 'string',
                'label' => 'Електронна адреса',
                'placeholder' => 'Введіть поштовий індекс',
                'column' => 'full',
                'value' => old('email', $model?->email),
            ],
            'phone' => [
                'type' => 'string',
                'label' => 'Телефон',
                'placeholder' => 'Введіть адресу',
                'column' => 'full',
                'value' => old('phone', $model?->phone),
            ],
            'message' => [
                'type' => 'string',
                'label' => 'Повідомлення',
                'placeholder' => 'Введіть графік роботи',
                'column' => 'full',
                'value' => old('message', $model?->message),
            ],
        ];
    }
}
