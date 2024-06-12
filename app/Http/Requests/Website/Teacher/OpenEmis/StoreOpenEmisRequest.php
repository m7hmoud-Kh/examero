<?php

namespace App\Http\Requests\Website\Teacher\OpenEmis;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpenEmisRequest extends FormRequest
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
            'user_name' => ['required','string'],
            'password' => ['required','string'],
            'group' => ['required','string'],
            'subject' => ['required','string'],
            'phone_number' => ['required','digits:10'],
            'document' => ['required','mimes:jpg,png,jpeg,pdf'],
            'plan_id' => ['exists:plans,id']
        ];
    }
}
