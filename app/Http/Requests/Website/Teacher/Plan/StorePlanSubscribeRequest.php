<?php

namespace App\Http\Requests\Website\Teacher\Plan;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanSubscribeRequest extends FormRequest
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
            'plan_id' => ['required','exists:plans,id']
        ];
    }

    public function messages()
    {
        return [
            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

            'plan_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.plan_id')]),
        ];
    }
}
