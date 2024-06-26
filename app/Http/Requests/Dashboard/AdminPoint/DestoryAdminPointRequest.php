<?php

namespace App\Http\Requests\Dashboard\AdminPoint;

use Illuminate\Foundation\Http\FormRequest;

class DestoryAdminPointRequest extends FormRequest
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
            'adminIds' => ['required','array'],
            'adminIds.*' => ['exists:admins,id']
        ];
    }

    public function messages()
    {
        return [
            'adminIds.required' =>
            __('validation.required',['attribute' => __('validation.attributes.adminIds')]),
            'adminIds.array' =>
            __('validation.array',['attribute' => __('validation.attributes.adminIds')]),
            'adminIds.*.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.adminIds')]),
        ];
    }
}
