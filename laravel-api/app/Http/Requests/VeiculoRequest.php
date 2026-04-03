<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VeiculoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model'=>'required',
            'year'=>'required|integer|digits:4|between:1900,3001'
        ];
    }

    public function messages()
    {
        return [
            'model.required'=>'Campo modelo é obrigatório',

            'year.required'=>'Campo ano é obrigatório',
            'year.integer'=>'O ano deve ser um número inteiro',
            'year.digits'=>'O ano deve ter :digits digitos',
            'year.between'=>'O ano deve estar entre 1900 e o ano atual'
        ];
    }
}
