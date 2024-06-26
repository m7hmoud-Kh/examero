<?php

namespace App\Http\Requests\Dashboard\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'name' => ['required','string','unique:lessons'],
            'unit_id' => ['required','exists:units,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required',['attribute' => __('validation.attributes.lesson_name')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.lesson_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.lesson_name')]),

            'unit_id.required' => __('validation.required',['attribute' => __('validation.attributes.unit_id')]),
            'unit_id.exists' => __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),

        ];
    }
}
