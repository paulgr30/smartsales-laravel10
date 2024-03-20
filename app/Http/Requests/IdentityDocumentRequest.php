<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdentityDocumentRequest extends FormRequest
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
                'unique:identity_documents,name,' . $id . ',id',
            ],
            'description' => [
                'required',
                'string',
                'unique:identity_documents,description,' . $id . ',id',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'nombre',
            'description'   => 'descripcion',
        ];
    }
}
