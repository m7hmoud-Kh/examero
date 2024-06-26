<?php

namespace App\Http\Requests\Website\Teacher\OpenEmis;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpenEmisRequest extends FormRequest
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
            'user_name' => ['string'],
            'password_site' => ['string'],
            'group' => ['string'],
            'subject' => ['string'],
            'phone_number' => ['digits:10'],
            'document' => ['mimes:jpg,png,jpeg,pdf']
        ];
    }

    public function messages()
    {
        return [
            'user_name.string' => __('validation.string',['attribute' => __('validation.attributes.user_name')]),

            'password_site.string' => __('validation.string',['attribute' => __('validation.attributes.password_site')]),

            'subject.string' => __('validation.string',['attribute' => __('validation.attributes.subject')]),

            'group.string' => __('validation.string',['attribute' => __('validation.attributes.group')]),


            "phone_number.digits" =>
            __('validation.digits',['attribute' => __('validation.attributes.phone_number')]),

            "document.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.document'),
                'values' => 'jpg,png,jpeg,pdf',
            ]),

            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),


        ];
    }
}
