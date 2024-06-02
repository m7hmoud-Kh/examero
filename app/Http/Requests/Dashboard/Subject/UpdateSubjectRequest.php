<?php

namespace App\Http\Requests\Dashboard\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
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
            'name' => ['string',Rule::unique('subjects')->ignore($this->subjectId)],
            'status' => ['boolean'],
            'groupIds' => ['array'],
            'groupIds.*' => ['numeric','exists:groups,id']
        ];
    }
}
