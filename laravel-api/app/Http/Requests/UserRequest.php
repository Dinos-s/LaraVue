<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'name' => 'required_if:name,!=, null',
            'email' => 'required_if:email,!=, null|email|unique:users,email,' . ($user ? $user->id : null),
            'password' => 'required_if:password,!=, null|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'O campo nome deve ser preenchido',
            'email.required' => 'O campo email deve ser preenchido',
            'email.email' => 'O campo email deve ser um email',
            'email.unique' => 'O email informado ja existe',
            'password.required' => 'O campo senha deve ser preenchido',
            'password.confirmed' => 'As senhas não coecidem',
            'password.min' => 'O campo senha deve ter no minimo :min caracteres'
        ];
    }
}
