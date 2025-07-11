<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            'new_password_confirmation' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Текущий пароль обязателен.',
            'new_password.required' => 'Новый пароль обязателен.',
            'new_password.min' => 'Новый пароль должен содержать не менее 6 символов.',
            'new_password.confirmed' => 'Пароли не совпадают.',
            'new_password_confirmation.required' => 'Подтверждение нового пароля обязательно.',
        ];
    }
}
