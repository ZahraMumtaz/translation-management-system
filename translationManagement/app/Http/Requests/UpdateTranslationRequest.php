<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;



class UpdateTranslationRequest extends FormRequest
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
        $translationId = $this->route('id');
        return [
            'key' => 'string|min:3|max:500',
            'context' => ['string', 'min:3', 'max:255', Rule::exists('tags', 'name')],
            'locale' => ['string', 'size:2'],
            'content' => 'string|min:3|max:500',
            Rule::unique('translations')->ignore($translationId)
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => 'true',
            'data' => $validator->errors()
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
