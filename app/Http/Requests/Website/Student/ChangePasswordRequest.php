<?php

namespace App\Http\Requests\Website\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'current_password' => ['required','current_password:api']
        ];
    }

    public function messages()
    {
        return [
            "password.required" =>
            __('validation.required',['attribute' => __('validation.attributes.password')]),
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

            "current_password.required" =>
            __('validation.required',['attribute' => __('validation.attributes.current_password')]),

            "current_password.current_password" => __('validation.current_password'),


        ];
    }
}
