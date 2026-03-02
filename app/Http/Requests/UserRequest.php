<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $user_id = $this->route('user');

        return [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user_id)
            ],
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
            'email.unique' => 'This email is already registered',
            'password.required' => 'Field password is required',
            'password.min' => 'Field password must have more than 6 characters',
        ];
    }
}
