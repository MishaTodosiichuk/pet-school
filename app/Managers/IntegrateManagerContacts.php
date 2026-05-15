<?php

namespace App\Managers;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class IntegrateManagerContacts extends BaseIntegrateManager
{
    public function getModuleName(): string
    {
        return 'contact';
    }

    public function getModuleTitle(): string
    {
        return 'Контакти';
    }

    public function getModuleIcon(): string
    {
        return 'fas fa-address-card';
    }

    public function getModelClass(): string
    {
        return Contact::class;
    }

    protected function getTableColumns(): array
    {
        return [
            'id'          => ['label' => 'ID', 'class' => 'text-center', 'type' => 'id'],
            'code_edrpou' => ['label' => 'Код', 'class' => ''],
            'address'     => ['label' => 'Адреса', 'class' => ''],
            'schedule'    => ['label' => 'Розклад', 'class' => ''],
            'email'       => ['label' => 'Електронна адреса', 'class' => ''],
        ];
    }

    public function getFields(?Model $model = null): array
    {
        $model = $model ?? new ($this->getModelClass());

        return [
            'code_edrpou' => [
                'type' => 'string',
                'label' => 'Код ЄДРПОУ',
                'placeholder' => 'Введіть код',
                'column' => 'full',
                'value' => old('code_edrpou', $model?->code_edrpou),
            ],
            'zip_code' => [
                'type' => 'string',
                'label' => 'Поштовий індекс',
                'placeholder' => 'Введіть поштовий індекс',
                'column' => 'full',
                'value' => old('zip_code', $model?->zip_code),
            ],
            'address' => [
                'type' => 'string',
                'label' => 'Адреса',
                'placeholder' => 'Введіть адресу',
                'column' => 'full',
                'value' => old('address', $model?->address),
            ],
            'schedule' => [
                'type' => 'string',
                'label' => 'Графік роботи',
                'placeholder' => 'Введіть графік роботи',
                'column' => 'full',
                'value' => old('schedule', $model?->schedule),
            ],
            'email' => [
                'type' => 'string',
                'label' => 'E-Mail адреса',
                'placeholder' => 'Введіть email',
                'column' => 'full',
                'value' => old('email', $model?->email),
            ],
            'phone_number' => [
                'type' => 'string',
                'label' => 'Контактний телефон',
                'placeholder' => 'Введіть телефон',
                'column' => 'full',
                'value' => old('phone_number', $model?->phone_number),
            ],
            'head_institution' => [
                'type' => 'string',
                'label' => 'Керівник установи',
                'placeholder' => 'Введіть ПІБ',
                'column' => 'full',
                'value' => old('head_institution', $model?->head_institution),
            ],
        ];
    }
}
