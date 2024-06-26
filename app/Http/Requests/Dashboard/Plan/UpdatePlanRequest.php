<?php

namespace App\Http\Requests\Dashboard\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
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
            'name' => ['string'],
            'description' => ['string'],
            'price' => ['numeric'],
            'allow_exam' => ['numeric'],
            'allow_question' => ['numeric'],
            'for_student' => ['boolean'],
            'status' => ['boolean']
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.plan_name')]),

            'description.string' => __('validation.string',['attribute' => __('validation.attributes.description')]),

            'price.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.price')]),

            'allow_exam.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.allow_exam')]),

            'allow_question.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.allow_question')]),

            'for_student.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.for_student')]),

            'status.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.status')]),

        ];
    }
}
