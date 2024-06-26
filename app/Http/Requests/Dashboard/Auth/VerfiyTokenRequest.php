<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerfiyTokenRequest extends FormRequest
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
            'token' => ['required','string','exists:password_reset_tokens,token'],
        ];
    }

    public function messages()
    {
        return [
            'token.required' =>
            __('validation.required',['attribute' =>  __('validation.attributes.token')]),
            'token.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.token')]),
            'token.string' => __('validation.string',['attribute' => __('validation.attributes.token')]),
        ];
    }
}
