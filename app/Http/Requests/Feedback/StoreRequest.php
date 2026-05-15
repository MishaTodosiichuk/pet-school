<?php

namespace App\Http\Requests\Feedback;

use App\Rules\Recaptcha;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:150'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'captcha' => ['required', new Recaptcha],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Будь ласка, вкажіть ваше прізвище та ініціали.',
            'name.min'      => 'Прізвище має містити не менше :min символів.',
            'name.max'      => 'Прізвище занадто довге (максимум :max символів).',

            'email.required' => 'Адреса електронної пошти обов’язкова для зв’язку.',
            'email.email'    => 'Введіть коректну адресу електронної пошти.',
            'email.max'      => 'Email не може бути довшим за :max символів.',

            'phone.max'      => 'Номер телефону занадто довгий.',

            'message.required' => 'Ви не ввели текст повідомлення.',
            'message.min'      => 'Повідомлення має бути змістовним (мінімум :min символів).',
            'message.max'      => 'Повідомлення занадто велике (максимум :max символів).',
        ];
    }
}
