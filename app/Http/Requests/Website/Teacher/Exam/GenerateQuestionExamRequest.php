<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateQuestionExamRequest extends FormRequest
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
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'question_type_id' => ['required','exists:question_types,id'],
            'for' => ['required',Rule::in(1,2,3)],
            'level' => ['required',Rule::in(1,2,3,4,5)],
            'semster' => ['required',Rule::in(1,2)],
            'lesson_id' => ['exists:lessons,id'],
            'unit_id' => ['exists:units,id','required_with:lesson_id'],
            'count' => ['numeric'],
            'plan_id' => ['exists:plans,id'],
            'teacher_id' => ['exists:teachers,id']
        ];
    }


    public function messages()
    {
        return [
            'group_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.group_id')]),
            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),

            'subject_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.subject_id')]),
            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),

            'question_type_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.question_type_id')]),
            'question_type_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.question_type_id')]),

            'semster.required' =>
            __('validation.required',['attribute' => __('validation.attributes.semster')]),

            'level.required' =>
            __('validation.required',['attribute' => __('validation.attributes.level')]),

            'for.required' =>
            __('validation.required',['attribute' => __('validation.attributes.for')]),



            'lesson_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.lesson_id')]),

            'unit_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),
            "unit_id.required_with" => __('validation.required_with',
            [
            'attribute' => __('validation.attributes.unit_id'),
            'value'=> __('validation.attributes.lesson_id')
            ]),

            'plan_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.plan_id')]),
            
            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

            'teacher_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.teacher_id')]),

            'count.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.count')]),


        ];
    }
}
