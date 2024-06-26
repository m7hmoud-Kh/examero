<?php

namespace App\Http\Requests\Dashboard\Subject;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'name' => ['required','string','unique:subjects'],
            'groupIds' => ['required','array'],
            'groupIds.*' => ['numeric','exists:groups,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>
            __('validation.required',['attribute' => __('validation.attributes.subject_name')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.subject_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.subject_name')]),

            'groupIds.required' =>
            __('validation.required',['attribute' => __('validation.attributes.groupIds')]),
            'groupIds.array' =>
            __('validation.array',['attribute' => __('validation.attributes.groupIds')]),

            'groupIds.*.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.groupIds')]),
            'groupIds.*.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.groupIds')]),
        ];
    }
}
