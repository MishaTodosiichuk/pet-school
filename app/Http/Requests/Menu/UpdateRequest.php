<?php

namespace App\Http\Requests\Menu;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $menuId = $this->route('menu')->id ?? $this->route('menu');

        return [
            'title' => ['required','string','max:150','min:3'],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                'min:3',
                Rule::unique('menus', 'slug')->ignore($menuId)],
            'publish' => ['nullable','boolean'],
            'parent_id' => ['nullable','integer','exists:menus,id'],
        ];
    }
}
