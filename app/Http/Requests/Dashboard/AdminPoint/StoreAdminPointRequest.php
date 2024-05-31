<?php

namespace App\Http\Requests\Dashboard\AdminPoint;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminPointRequest extends FormRequest
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
            'message' => ['required','string'],
            'points' => ['required','integer','min:0'],
            'type' => ['required', Rule::in(1,2,3,4) ],
            'admin_id' => ['required','exists:admins,id']
        ];
    }
}
