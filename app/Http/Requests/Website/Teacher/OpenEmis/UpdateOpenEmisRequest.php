<?php

namespace App\Http\Requests\Website\Teacher\OpenEmis;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpenEmisRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => ['string'],
            'password_site' => ['string'],
            'group' => ['string'],
            'subject' => ['string'],
            'phone_number' => ['digits:10'],
            'document' => ['mimes:jpg,png,jpeg,pdf']
        ];
    }
}
