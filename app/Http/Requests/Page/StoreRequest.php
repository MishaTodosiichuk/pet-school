<?php

namespace App\Http\Requests\Page;

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
            'title'               => ['required', 'string', 'max:150', 'min:3'],
            'blocks'              => ['nullable', 'array'],
            'blocks.*.title'      => ['nullable', 'string', 'max:255'],
            'blocks.*.text'       => ['nullable', 'string'],
            'blocks.*.publish'    => ['nullable', 'boolean'],
            'blocks.*.sort_order' => ['nullable', 'integer'],
            'blocks.*.file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx'],
            'blocks.*.images'     => ['nullable', 'array'],
            'blocks.*.images.*'   => ['nullable', 'image'],
        ];
    }
}
