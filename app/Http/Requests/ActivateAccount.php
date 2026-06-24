<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class ActivateAccount extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identity_number' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', new Enum(UserRole::class)],
            'password' => 'required|min:8|confirmed'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi Error',
                'error' => [
                    $validator->errors()
                ]
            ], 422)
        );
    }
}
