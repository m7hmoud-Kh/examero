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

    public function messages()
    {
        return [
            'first_name.string' => __('validation.string',['attribute' => __('validation.attributes.first_name')]),

            'last_name.string' => __('validation.string',['attribute' => __('validation.attributes.last_name')]),

            'email.email' => __('validation.email'),
            'email.unique' =>
            __('validation.unique',['attribute' => __('validation.attributes.email')]),

            "password.confirmed" =>
            __('validation.confirmed',['attribute' => __('validation.attributes.password')]),
            "password.letters" =>
            __('validation.letters',['attribute' => __('validation.attributes.password')]),
            "password.min" =>
            __('validation.min',[
                'attribute' => __('validation.attributes.password'),
                'value' => 8
            ]),
            "password.numbers" =>
            __('validation.numbers',['attribute' => __('validation.attributes.password')]),

            "phone_number.digits" =>
            __('validation.digits',['attribute' => __('validation.attributes.phone_number')]),
            
            "date_of_birth.date" => __('validation.date'),
        ];
    }
}
