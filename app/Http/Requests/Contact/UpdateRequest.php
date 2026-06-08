<?php

namespace App\Http\Requests\Contact;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
        $contactId = $this->route('contact')->id ?? $this->route('contact');

        return [
            'code_edrpou'      => ['required','string','max:10','min:5', 'unique:contacts,code_edrpou' . $contactId],
            'zip_code'         => ['required', 'string', 'max:10', 'min:5'],
            'address'          => ['required','string','max:150', 'min:10'],
            'schedule'         => ['required','string','max:100', 'min:5'],
            'email'            => ['required','string','max:100', 'min:5', 'email'],
            'phone_number'     => ['required','string','max:20', 'min:10'],
            'head_institution' => ['required','string','max:150', 'min:10'],
        ];
    }
}
