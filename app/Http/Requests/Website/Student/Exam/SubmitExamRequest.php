<?php

namespace App\Http\Requests\Website\Student\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitExamRequest extends FormRequest
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
            'answers' => ['required','array'],
            'answers.*' => ['array','exists:options,id'],
            'group_id' => ['required_with:subject_id','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'semster' => ['required',Rule::in([1,2])],
            'lesson_id' => ['exists:lessons,id'],
            'unit_id' => ['exists:units,id','required_with:lesson_id'],
        ];
    }


    public function messages()
    {
        return [
            'answers.required' =>
            __('validation.required',['attribute' => __('validation.attributes.answers')]),
            'answers.array' =>
            __('validation.array',['attribute' => __('validation.attributes.answers')]),

            'answers.*.array' =>
            __('validation.array',['attribute' => __('validation.attributes.answers')]),
            'answers.*.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.answers')]),

            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),
            "group_id.required_with" => __('validation.required_with',
            [
            'attribute' => __('validation.attributes.group_id'),
            'value'=> __('validation.attributes.subject_id')
            ]),

            'subject_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.subject_id')]),
            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),

            'semster.required' =>
            __('validation.required',['attribute' => __('validation.attributes.semster')]),

            'lesson_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.lesson_id')]),

            'unit_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),
            "unit_id.required_with" => __('validation.required_with',
            [
            'attribute' => __('validation.attributes.unit_id'),
            'value'=> __('validation.attributes.lesson_id')
            ]),
        ];
    }
}
