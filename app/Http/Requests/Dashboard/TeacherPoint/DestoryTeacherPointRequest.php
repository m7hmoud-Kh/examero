<?php

namespace App\Http\Requests\Dashboard\TeacherPoint;

use Illuminate\Foundation\Http\FormRequest;

class DestoryTeacherPointRequest extends FormRequest
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
            'tearcherIds' => ['required','array'],
            'tearcherIds.*' => ['exists:teachers,id']
        ];
    }

    public function messages()
    {
        return [
            'tearcherIds.required' =>
            __('validation.required',['attribute' => __('validation.attributes.tearcherIds')]),
            'adminIds.array' =>
            __('tearcherIds.array',['attribute' => __('validation.attributes.tearcherIds')]),
            'tearcherIds.*.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.tearcherIds')]),
        ];
    }
}
