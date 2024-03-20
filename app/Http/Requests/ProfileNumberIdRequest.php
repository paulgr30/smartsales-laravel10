<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileNumberIdRequest extends FormRequest
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
        return [
            'profile.number_id' => [
                'required',
                'min:8',
                'max:15',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'profile.number_id' => 'numero documento',
        ];
    }
}
