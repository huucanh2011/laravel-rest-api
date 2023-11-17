<?php

namespace App\Http\Requests\User;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role->value == RoleEnum::ADMINISTRATOR->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'role' => ['required', new Enum(RoleEnum::class)],
            'address' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:100',
            'phone_number' => 'required|max:20',
            'password' => 'required|min:6',
        ];
    }
}
