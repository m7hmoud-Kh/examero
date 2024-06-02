<?php

namespace App\Http\Requests\Dashboard\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateStudentRequest extends FormRequest
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
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['email',Rule::unique('users')->ignore($this->studentId)],
            'password' => [Password::min(8)->letters()->numbers()],
            'phone_number' => ['string','digits:10'],
            'date_of_birth' => ['date']
        ];
    }
}
