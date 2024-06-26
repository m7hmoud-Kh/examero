<?php

namespace App\Http\Requests\Dashboard\OpenEmis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOpenEmisRequest extends FormRequest
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
            'status' => [Rule::in(2,3)],
            'note' => ['string']
        ];
    }

    public function messages()
    {
        return [
            'status.in' =>
            __('validation.custom.status_open_emis.in',['attribute' => __('validation.attributes.status')]),
            
            'note.string' => __('validation.string',['attribute' => __('validation.attributes.note')]),
        ];
    }
}
