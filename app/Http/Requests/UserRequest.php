<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
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

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users, email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Field name is required',
            'name.max' => 'Field name cannot have more than 255 characters',
            'email.required' => 'Field email is required',
            'email.email' => 'Field email must be an email',
            'email.max' => 'Field email cannot have more than 255 characters',
            'password.required' => 'Field password is required',
            'password.min' => 'Field password must have more than 6 characters',
        ];
    }
}
