<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
        $id = empty($this->id) ? 0 : $this->id;
        return [
            'ruc' => [
                'required',
                'numeric',
                'min_digits:11',
                'unique:configurations,ruc,' . $id . ',id',
            ],
            'name_business' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'phone' => [
                'required',
                'min:6',
                'max:12',
            ],
            'email' => [
                'required',
                'email',
            ],
            'sales_tax' => [
                'required',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name_business' => 'nombre comercial',
            'address'       => 'direccion',
            'phone'         => 'telefono',
            'email'         => 'correo',
            'sales_tax'     => 'impuesto a las ventas',
        ];
    }
}
