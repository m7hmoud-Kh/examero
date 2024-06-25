<?php

namespace App\Http\Requests\Website\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileTeacherRequest extends FormRequest
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
            'email' => ['email',Rule::unique('teachers')->ignore(Auth::guard('teacher')->user()->id)],
            'phone_number' => ['string','digits:10'],
            'date_of_birth' => ['date'],
            'image' => ['mimes:png,jpg,jpeg']
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


            "phone_number.digits" =>
            __('validation.digits',['attribute' => __('validation.attributes.phone_number')]),

            "date_of_birth.date" => __('validation.date'),

            "image.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.avatar'),
                'values' => 'jpg, png, jpeg',
            ])
        ];
    }
}
