<?php

namespace App\Http\Requests\Dashboard\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
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
            'name' => ['string'],
            'description' => ['string'],
            'price' => ['numeric'],
            'allow_exam' => ['numeric'],
            'allow_question' => ['numeric'],
            'for_student' => ['boolean'],
            'status' => ['boolean']
        ];
    }
}
