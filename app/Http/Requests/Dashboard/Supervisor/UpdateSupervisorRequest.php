<?php

namespace App\Http\Requests\Dashboard\Supervisor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateSupervisorRequest extends FormRequest
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
            'email' => ['email',Rule::unique('admins')->ignore($this->supervisorId)],
            'password' => [Password::min(8)->letters()->numbers()],
            'phone_number' => ['string','digits:10'],
            'governorate' => ['string'],
            'date_of_birth' => ['date']
        ];
    }
}