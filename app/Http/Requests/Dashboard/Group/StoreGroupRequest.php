<?php

namespace App\Http\Requests\Dashboard\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'name' => ['required','string','unique:groups'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required',['attribute' => __('validation.attributes.group_name')]),
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.group_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.group_name')]),
        ];
    }
}
