<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreTranslationRequest extends FormRequest
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
            'key' => 'required|string|min:3|max:500',
            'context' => ['required', 'string', 'min:3', 'max:255', Rule::exists('tags', 'name')],
            'locale' => ['required', 'string', 'size:2'],
            'content' => 'required|string|min:3|max:500'
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
