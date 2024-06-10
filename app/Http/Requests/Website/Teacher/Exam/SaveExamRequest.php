<?php

namespace App\Http\Requests\Website\Teacher\Exam;

use Illuminate\Foundation\Http\FormRequest;

class SaveExamRequest extends FormRequest
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
            'questionIds' => ['required','array','min:1'],
            'questionIds.*' => ['exists:questions,id'],
            'plan_id' => ['exists:plans,id']
        ];
    }
}
