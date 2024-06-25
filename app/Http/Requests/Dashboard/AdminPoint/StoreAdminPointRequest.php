<?php

namespace App\Http\Requests\Dashboard\AdminPoint;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminPointRequest extends FormRequest
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
            'message' => ['required','string'],
            'points' => ['required','integer','min:0'],
            'type' => ['required', Rule::in(1,2,3,4) ],
            'admin_id' => ['required','exists:admins,id']
        ];
    }

    public function messages()
    {
        return [
            'message.required' => __('validation.required',['attribute' => __('validation.attributes.message')]),
            'message.string' => __('validation.string',['attribute' => __('validation.attributes.message')]),

            'points.required' => __('validation.required',['attribute' => __('validation.attributes.points')]),

            'points.integer' => __('validation.integer',['attribute' => __('validation.attributes.points')]),
            'points.min' => __('validation.min',[
                'attribute' => __('validation.attributes.points'),
                'value' => 0
            ]),

            'type.required' => __('validation.required',['attribute' => __('validation.attributes.type')]),

            'type.in' => __('validation.custom.type.in',['attribute' => __('validation.attributes.type')]),

            'admin_id.required' => __('validation.required',['attribute' => __('validation.attributes.admin_id')]),
            'admin_id.exists' => __('validation.exists',['attribute' => __('validation.attributes.admin_id')]),




        ];
    }
}
