<?php

namespace App\Http\Requests\Dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
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
            'name' => ['string',Rule::unique('questions')->ignore($this->questionId)],
            'point' => ['numeric'],
            'group_id' => ['exists:groups,id'],
            'subject_id' => ['exists:subjects,id'],
            'unit_id' => ['exists:units,id'],
            'lesson_id' => ['exists:lessons,id'],
            'question_type_id' => ['exists:question_types,id'],
            'level' => [Rule::in(1,2,3,4,5)],
            'semster' => [Rule::in(1,2)],
            'for' => [Rule::in(1,2,3)],
            'status' => [Rule::in(2,3)],
            'has_branch' => ['boolean'],
            'is_choose' => ['boolean'],
            'image' => ['mimes:jpg,png,jpeg'],
            'options' => ['array','min:1'],
            'options.*.option' => ['required','string'],
            'options.*.is_correct' => ['required','boolean'],
            'options.*.image' => ['mimes:jpg,png,jpeg',]
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.questionName')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.questionName')]),

            'point.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.point')]),

            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),

            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),

            'unit_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),

            'lesson_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.lesson_id')]),

            'question_type_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.question_type_id')]),

            'level.in' =>
            __('validation.custom.level.in',['attribute' => __('validation.attributes.level')]),
            'semster.in' =>
            __('validation.custom.semster.in',['attribute' => __('validation.attributes.semster')]),

            'for.in' =>
            __('validation.custom.for.in',['attribute' => __('validation.attributes.for')]),

            'status.in' =>
            __('validation.custom.status_open_emis.in',['attribute' => __('validation.attributes.status')]),

            'has_branch.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.has_branch')]),

            'is_choose.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.is_choose')]),

            "image.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.question_image'),
                'values' => 'jpg,png,jpeg',
            ]),

            'options.array' =>
            __('validation.array',['attribute' => __('validation.attributes.options')]),

            "options.min" =>
            __('validation.min',[
                'attribute' => __('validation.attributes.options'),
                'value' => 1
            ]),

            'options.*.option.string' =>
            __('validation.string',['attribute' => __('validation.attributes.option')]),


            'options.*.is_correct.boolean' =>
            __('validation.boolean',['attribute' => __('validation.attributes.is_correct')]),

            "options.*.image.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.option_image'),
                'values' => 'jpg,png,jpeg',
            ]),


        ];
    }
}
