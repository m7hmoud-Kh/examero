<?php

namespace App\Http\Requests\Dashboard\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
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
            'name' => ['string',Rule::unique('subjects')->ignore($this->subjectId)],
            'status' => ['boolean'],
            'groupIds' => ['array'],
            'groupIds.*' => ['numeric','exists:groups,id']
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.subject_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.subject_name')]),

            'status.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.status')]),

            'groupIds.array' =>
            __('validation.array',['attribute' => __('validation.attributes.groupIds')]),
            'groupIds.*.numeric' =>
            __('validation.numeric',['attribute' => __('validation.attributes.groupIds')]),
            'groupIds.*.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.groupIds')]),
        ];
    }
}
