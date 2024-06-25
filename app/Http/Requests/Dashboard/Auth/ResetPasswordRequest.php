<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'password' => ['required', 'string', Password::min(8)->letters()->numbers() ,'confirmed'],
            'token' => ['required','string','exists:password_reset_tokens,token'],
            'email' => ['required','exists:password_reset_tokens,email']
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

            'token.required' =>
            __('validation.required',['attribute' =>  __('validation.attributes.token')]),
            'token.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.token')]),
            'token.string' => __('validation.string',['attribute' => __('validation.attributes.token')]),


            'email.required' =>
            __('validation.required',['attribute' =>  __('validation.attributes.email')]),
            'email.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.email')]),

        ];
    }
}
