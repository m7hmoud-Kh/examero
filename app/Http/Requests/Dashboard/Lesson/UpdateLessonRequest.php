<?php

namespace App\Http\Requests\Dashboard\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
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
            'name' => ['string',Rule::unique('lessons')->ignore($this->lessonId)],
            'status' => ['boolean'],
            'unit_id' => ['exists:units,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.lesson_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.lesson_name')]),

            'status.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.status')]),
            'unit_id.exists' => __('validation.exists',['attribute' => __('validation.attributes.unit_id')]),


        ];
    }
}
