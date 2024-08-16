<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePdfsInfoRequest extends FormRequest
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
            'mediaQuestion' => ['required','mimes:pdf','max:51200'],
            'mediaAnswer' => ['required','mimes:pdf','max:51200'],
            'plan_id' => ['exists:plans,id'],
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

            "mediaQuestion.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.mediaQuestion'),
                'values' => 'pdf',
            ]),

            "mediaQuestion.required" =>  __('validation.required',[
                'attribute' =>  __('validation.attributes.mediaQuestion')
            ]),

            "mediaAnswer.mimes" =>  __('validation.mimes',[
                'attribute' =>  __('validation.attributes.mediaAnswer'),
                'values' => 'pdf',
            ]),


            "mediaAnswer.required" =>  __('validation.required',[
                'attribute' =>  __('validation.attributes.mediaAnswer')
            ]),


            'plan_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.plan_id')]),

        ];
    }
}
