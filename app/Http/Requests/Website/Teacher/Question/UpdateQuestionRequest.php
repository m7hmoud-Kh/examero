<?php

namespace App\Http\Requests\Website\Teacher\Question;

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
            'has_branch' => ['boolean'],
            'is_choose' => ['boolean'],
            'image' => ['mimes:jpg,png,jpeg'],
            'options' => ['array','min:1'],
            'options.*.option' => ['required','string'],
            'options.*.is_correct' => ['required','boolean'],
            'options.*.image' => ['mimes:jpg,png,jpeg',]
        ];
    }
}
