<?php

namespace App\Http\Requests\Dashboard\Unit;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'name' => ['required','string','unique:units'],
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>
            __('validation.required',['attribute' => __('validation.attributes.unit_name')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.unit_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.unit_name')]),

            'group_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.group_id')]),
            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),

            'subject_id.required' =>
            __('validation.required',['attribute' => __('validation.attributes.subject_id')]),
            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),
        ];
    }
}
