<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class TeacherLoginRequest extends FormRequest
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
            'email' => ['required','email','exists:teachers,email'],
            'password' => ['required','string']
        ];
    }


    public function messages()
    {
        return [
            'email.required' =>
            __('validation.required',['attribute' =>  __('validation.attributes.email')]),
            'email.email' => __('validation.email'),
            'email.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.email')]),
            "password.required" =>
            __('validation.required',['attribute' => __('validation.attributes.password')]),
        ];
    }
}
