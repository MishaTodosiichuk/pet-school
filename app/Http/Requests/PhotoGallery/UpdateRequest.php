<?php

namespace App\Http\Requests\PhotoGallery;

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
        $galleryId = $this->route('gallery')->id ?? $this->route('gallery');

        return [
            'title'            => ['required', 'string', 'max:150', 'min:3'],
            'key'              => ['required', 'string', 'max:150', 'min:3', 'unique:photo_galleries,key,' . $galleryId],
            'publish'          => ['nullable', 'boolean'],

            'images'           => ['nullable', 'array'],
            'images.*'         => ['integer', 'exists:images,id'],

            'images_uploads'   => ['nullable', 'array'],
            'images_uploads.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
