<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = empty($this->id) ? 0 : $this->id;

        return [
            'name' => [
                'required',
                'string',
                'unique:units,name,' . $id . ',id',
            ],
            'is_active' => [
                'required',
                'boolean'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'nombre',
            'is_active'     => 'estado',
        ];
    }
}
