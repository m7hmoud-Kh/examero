<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateQuestionExamRequest extends FormRequest
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
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'question_type_id' => ['required','exists:question_types,id'],
            'for' => ['required',Rule::in(1,2,3)],
            'level' => ['required',Rule::in(1,2,3,4,5)],
            'semster' => ['required',Rule::in(1,2)],
            'lesson_id' => ['exists:lessons,id'],
            'unit_id' => ['exists:units,id','required_with:lesson_id'],
            'count' => ['numeric']
        ];
    }
}
