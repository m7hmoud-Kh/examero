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

    public function messages()
    {
        return [

            'name.string' => __('validation.string',['attribute' => __('validation.attributes.unit_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.unit_name')]),

            'status.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.status')]),

            'group_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.group_id')]),

            'subject_id.exists' =>
            __('validation.exists',['attribute' => __('validation.attributes.subject_id')]),
        ];
    }
}
