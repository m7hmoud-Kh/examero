<?php

namespace App\Http\Requests\Dashboard\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreManagerRequest extends FormRequest
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
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'email' => ['required','email','unique:admins'],
            'password' => ['required',Password::min(8)->letters()->numbers()],
            'phone_number' => ['required','string','digits:10'],
            'governorate' => ['required','string']
        ];
    }
}
