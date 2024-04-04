<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordAuthRequest extends FormRequest
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
            'current_password'          => ['required', 'current_password',],
            'new_password'              => ['required', 'confirmed', 'min:8',],
            'new_password_confirmation' => ['required', 'min:8',],
        ];
    }

    public function attributes()
    {
        return [
            'current_password'          => 'contraseña actual',
            'new_password'              => 'nueva contraseña',
            'new_password_confirmation' => 'confirmar nueva contraseña'
        ];
    }
}
