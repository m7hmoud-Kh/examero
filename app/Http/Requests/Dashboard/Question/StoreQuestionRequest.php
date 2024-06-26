<?php

namespace App\Http\Requests\Dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
            'name' => ['required','string','unique:questions'],
            'point' => ['required','numeric'],
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'unit_id' => ['required','exists:units,id'],
            'lesson_id' => ['required','exists:lessons,id'],
            'question_type_id' => ['required','exists:question_types,id'],
            'level' => ['required',Rule::in(1,2,3,4,5)],
            'semster' => ['required',Rule::in(1,2)],
            'for' => ['required',Rule::in(1,2,3)],
            'has_branch' => ['required','boolean'],
            'is_choose' => ['required','boolean'],
            'image' => ['mimes:jpg,png,jpeg'],
            'options' => ['required','array','min:1'],
            'options.*.option' => ['required','string'],
            'options.*.is_correct' => ['required','boolean'],
            'options.*.image' => ['mimes:jpg,png,jpeg',]
        ];
    }


    public function messages()
    {
        return [
            'name.required' =>
            __('validation.required',['attribute' => __('validation.attributes.questionName')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.questionName')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.questionName')]),

            'point.required' =>
            __('validation.required',['attribute' => __('validation.attributes.point')]),

            'point.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.point')]),

            'group_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.group_id')]),
            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),

            'subject_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.subject_id')]),
            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),

            'unit_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.unit_id')]),
            'unit_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),

            'lesson_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.lesson_id')]),
            'lesson_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.lesson_id')]),

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

            'has_branch.required' =>
            __('validation.required',['attribute' => __('validation.attributes.has_branch')]),
            'has_branch.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.has_branch')]),

            'is_choose.required' =>
            __('validation.required',['attribute' => __('validation.attributes.is_choose')]),
            'is_choose.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.is_choose')]),

            "image.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.question_image'),
                'values' => 'jpg,png,jpeg',
            ]),

            'options.required' =>
            __('validation.required',['attribute' => __('validation.attributes.options')]),
            'options.array' =>
            __('validation.array',['attribute' => __('validation.attributes.options')]),

            "options.min" =>
            __('validation.min',[
                'attribute' => __('validation.attributes.options'),
                'value' => 1
            ]),

            'options.*.option.required' =>
            __('validation.required',['attribute' => __('validation.attributes.option')]),

            'options.*.option.string' =>
            __('validation.string',['attribute' => __('validation.attributes.option')]),


            'options.*.is_correct.required' =>
            __('validation.required',['attribute' => __('validation.attributes.is_correct')]),

            'options.*.is_correct.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.is_correct')]),

            "options.*.image.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.option_image'),
                'values' => 'jpg,png,jpeg',
            ]),

        ];

    }
}
