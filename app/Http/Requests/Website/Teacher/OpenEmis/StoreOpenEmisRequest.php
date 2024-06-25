<?php

namespace App\Http\Requests\Website\Teacher\OpenEmis;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpenEmisRequest extends FormRequest
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
            'user_name' => ['required','string'],
            'password_site' => ['required','string'],
            'group' => ['required','string'],
            'subject' => ['required','string'],
            'phone_number' => ['required','digits:10'],
            'document' => ['required','mimes:jpg,png,jpeg,pdf'],
            'plan_id' => ['exists:plans,id']
        ];
    }


    public function messages()
    {
        return [
            'user_name.required' => __('validation.required',['attribute' => __('validation.attributes.user_name')]),
            'user_name.string' => __('validation.string',['attribute' => __('validation.attributes.user_name')]),

            'password_site.required' => __('validation.required',['attribute' => __('validation.attributes.password_site')]),
            'password_site.string' => __('validation.string',['attribute' => __('validation.attributes.password_site')]),

            'subject.required' => __('validation.required',['attribute' => __('validation.attributes.subject')]),
            'subject.string' => __('validation.string',['attribute' => __('validation.attributes.subject')]),

            'group.required' => __('validation.required',['attribute' => __('validation.attributes.group')]),
            'group.string' => __('validation.string',['attribute' => __('validation.attributes.group')]),


            'phone_number.required' => __('validation.required',['attribute' => __('validation.attributes.phone_number')]),
            "phone_number.digits" =>
            __('validation.digits',['attribute' => __('validation.attributes.phone_number')]),

            'document.required' => __('validation.required',['attribute' => __('validation.attributes.document')]),
            "document.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.document'),
                'values' => 'jpg,png,jpeg,pdf',
            ]),

            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),


        ];
    }
}
