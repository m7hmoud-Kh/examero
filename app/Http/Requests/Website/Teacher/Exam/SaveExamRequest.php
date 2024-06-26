<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;

class SaveExamRequest extends FormRequest
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
            'questionIds' => ['required','array','min:1'],
            'questionIds.*' => ['exists:questions,id'],
            'plan_id' => ['exists:plans,id'],
            'teacher_id' => ['exists:teachers,id']
        ];
    }


    public function messages()
    {
        return [
            'questionIds.required' =>
            __('validation.required',['attribute' => __('validation.attributes.questionIds')]),
            'questionIds.array' =>
            __('validation.array',['attribute' => __('validation.attributes.questionIds')]),

            "questionIds.min" =>
            __('validation.min',[
                'attribute' => __('validation.attributes.questionIds'),
                'value' => 1
            ]),


            "questionIds.*.exists" =>
            __('validation.exists',[
                'attribute' => __('validation.attributes.questionIds'),
            ]),

            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

            'teacher_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.teacher_id')]),



        ];
    }
}
