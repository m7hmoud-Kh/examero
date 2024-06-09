<?php

namespace App\Http\Requests\Website\Teacher\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
            'name' => ['required','string','unique:questions'],
            'point' => ['required','numeric'],
            'group_id' => ['required','exists:groups,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'unit_id' => ['required','exists:units,id'],
            'lesson_id' => ['required','exists:lessons,id'],
            'question_type_id' => ['required','exists:question_types,id'],
            'level' => ['required',Rule::in(1,2,3,4,5)],
            'semster' => ['required',Rule::in(1,2)],
            'for' => ['required',Rule::in(1,2,3)],
            'has_branch' => ['required','boolean'],
            'is_choose' => ['required','boolean'],
            'image' => ['mimes:jpg,png,jpeg'],
            'options' => ['required','array','min:1'],
            'options.*.option' => ['required','string'],
            'options.*.is_correct' => ['required','boolean'],
            'options.*.image' => ['mimes:jpg,png,jpeg']
        ];
    }
}
