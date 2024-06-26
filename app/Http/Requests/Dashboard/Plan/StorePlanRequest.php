<?php

namespace App\Http\Requests\Dashboard\Plan;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'name' => ['required','string'],
            'description' => ['required','string'],
            'price' => ['required','numeric'],
            'allow_exam' => ['required','numeric'],
            'allow_question' => ['numeric'],
            'for_student' => ['required','boolean']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required',['attribute' => __('validation.attributes.plan_name')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.plan_name')]),

            'description.required' => __('validation.required',['attribute' => __('validation.attributes.description')]),
            'description.string' => __('validation.string',['attribute' => __('validation.attributes.description')]),
            
            'price.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.price')]),
            'price.required' =>
            __('validation.required',['attribute' => __('validation.attributes.price')]),

            'allow_exam.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.allow_exam')]),
            'allow_exam.required' =>
            __('validation.required',['attribute' => __('validation.attributes.allow_exam')]),

            'allow_question.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.allow_question')]),

            'for_student.required' =>
            __('validation.required',['attribute' => __('validation.attributes.for_student')]),
            'for_student.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.for_student')]),
        ];
    }
}
