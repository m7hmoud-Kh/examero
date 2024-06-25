<?php

namespace App\Http\Requests\Dashboard\AdminNote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminNoteRequest extends FormRequest
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
            'address' => ['string'],
            'note' => ['string']
        ];
    }

    public function messages()
    {
        return [
            'address.string' => __('validation.string',['attribute' => __('validation.attributes.address')]),

            'note.string' => __('validation.string',['attribute' => __('validation.attributes.note')]),
        ];
    }
}
