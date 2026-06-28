<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'identity_number' => 'required|min:8|max:18|unique:teachers,nip|unique:students,nisn|unique:administrators,nip|unique:mentors,identity_number',
            'name' => 'required',
            'role' => ['required', new Enum(UserRole::class)]
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
