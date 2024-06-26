<?php

namespace App\Http\Requests\Website\Student\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateExamRequest extends FormRequest
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
            'group_id' => ['required_with:subject_id','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'semster' => ['required',Rule::in([1,2])],
            'lesson_id' => ['exists:lessons,id'],
            'unit_id' => ['exists:units,id','required_with:lesson_id'],
            'plan_id' => ['required','exists:plans,id'],
            'filters_level' => ['required','array','min:1'],
            'filters_level.*.level' => ['required',Rule::in([1,2,3,4,5])],
            'filters_level.*.number' => ['required','numeric']
        ];
    }


    public function messages()
    {
        return [
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

            'plan_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.plan_id')]),
            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

            'filters_level.required' =>
            __('validation.required',['attribute' => __('validation.attributes.filters_level')]),
            'filters_level.array' =>
            __('validation.array',['attribute' => __('validation.attributes.filters_level')]),
            'filters_level.*.level.required' =>
            __('validation.required',['attribute' => __('validation.attributes.level')]),
            'filters_level.*.level.in' =>
            __('validation.custom.level.in',['attribute' => __('validation.attributes.level')]),
            'filters_level.*.number.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.number_level')]),
        ];
    }
}
