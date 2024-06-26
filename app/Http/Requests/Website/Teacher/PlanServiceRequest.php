<?php

namespace App\Http\Requests\Website\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class PlanServiceRequest extends FormRequest
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
            'plan_id' => ['exists:plans,id'],
            'teacher_id' => ['exists:teachers,id']
        ];
    }

    public function messages()
    {
        return [
            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

            'teacher_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.teacher_id')]),

        ];
    }
}
