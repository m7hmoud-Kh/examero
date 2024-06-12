<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePdfsInfoRequest extends FormRequest
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
            'subject_id' => ['required_with:group_id','exists:subjects,id'],
            'semster' => ['required',Rule::in([1,2])],
            'mediaQuestion' => ['required','mimes:pdf'],
            'mediaAnswer' => ['required','mimes:pdf'],
            'plan_id' => ['exists:plans,id'],
        ];
    }
}
