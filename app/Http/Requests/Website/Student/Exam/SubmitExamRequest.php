<?php

namespace App\Http\Requests\Website\Student\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitExamRequest extends FormRequest
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
            'answers' => ['required','array'],
            'answers.*' => ['required','array','exists:options,id'],
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required_with:group_id','exists:subjects,id'],
            'semster' => ['required',Rule::in([1,2])],
            'lesson_id' => ['exists:lessons,id'],
            'unit_id' => ['exists:units,id','required_with:lesson_id'],
        ];
    }
}