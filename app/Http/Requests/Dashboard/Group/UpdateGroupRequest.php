<?php

namespace App\Http\Requests\Dashboard\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends FormRequest
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
            'name' => ['string',Rule::unique('groups')->ignore($this->groupId)],
            'status' => ['boolean']
        ];
    }

    public function messages()
    {
        return [
            'name.string' => __('validation.string',['attribute' => __('validation.attributes.group_name')]),
            'name.unique' => __('validation.unique',['attribute' => __('validation.attributes.group_name')]),
            'status.boolean' => __('validation.boolean',['attribute' => __('validation.attributes.status')]),
        ];
    }
}
