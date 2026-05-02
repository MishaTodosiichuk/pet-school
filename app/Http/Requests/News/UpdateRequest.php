<?php

namespace App\Http\Requests\News;

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
        $newsId = $this->route('news')->id ?? $this->route('news');

        return [
            'title' => ['required', 'string', 'max:150', 'min:3'],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                'min:3',
                Rule::unique('news', 'slug')->ignore($newsId)],
            'description'    => ['required','string','max:10000'],
            'publish' => ['nullable', 'boolean'],

            'images'         => ['nullable', 'array'],
            'images.*'       => ['integer', 'exists:images,id'],

            'images_uploads'   => ['nullable', 'array'],
            'images_uploads.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
