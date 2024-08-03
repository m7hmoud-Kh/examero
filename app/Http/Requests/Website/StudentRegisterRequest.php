<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StudentRegisterRequest extends FormRequest
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
            'email' => ['required','email','unique:users'],
            'password' => ['required',Password::min(8)->letters()->numbers(),'confirmed'],
            'phone_number' => ['required','string','digits:10'],
            'date_of_birth' => ['required','date'],
            'group_id' => ['required','exists:groups,id']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.required',['attribute' => __('validation.attributes.first_name')]),
            'first_name.string' => __('validation.string',['attribute' => __('validation.attributes.first_name')]),

            'last_name.required' => __('validation.required',['attribute' => __('validation.attributes.last_name')]),
            'last_name.string' => __('validation.string',['attribute' => __('validation.attributes.last_name')]),

            'email.required' =>
            __('validation.required',['attribute' =>  __('validation.attributes.email')]),
            'email.email' => __('validation.email'),
            'email.unique' =>
            __('validation.unique',['attribute' => __('validation.attributes.email')]),

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


            "phone_number.required" =>
            __('validation.required',['attribute' => __('validation.attributes.phone_number')]),

            "phone_number.digits" =>
            __('validation.digits',['attribute' => __('validation.attributes.phone_number')]),

            "date_of_birth.required" =>
            __('validation.required',['attribute' =>  __('validation.attributes.date_of_birth')]),
            "date_of_birth.date" => __('validation.date'),


            "group_id.required" =>
            __('validation.required',['attribute' => __('validation.attributes.group_id')]),

            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),
        ];
    }
}
