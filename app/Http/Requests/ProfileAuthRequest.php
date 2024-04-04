<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileAuthRequest extends FormRequest
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
        $id = Auth::user()->id ?: 0;

        return [
            'name' => [
                'required',
                'string',
                'unique:users,name,' . $id . ',id',
            ],
            'email' => [
                'nullable',
                'email',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name'  => 'nombre',
            'email' => 'correo'
        ];
    }
}
