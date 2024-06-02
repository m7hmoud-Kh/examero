<?php

namespace App\Http\Requests\Dashboard\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
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
            'name' => ['string',Rule::unique('units')->ignore($this->unitId)],
            'status' => ['boolean'],
            'group_id' => ['exists:groups,id'],
            'subject_id' => ['exists:subjects,id']
        ];
    }
}
