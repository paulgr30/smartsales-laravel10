<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $profile_id = empty($this->id) ? 0 : $this->profile['id'];
        //dd($data);

        $rules = [
            'name' => [
                'required',
                'unique:users,name,' . $id . ',id',
            ],
            'email' => [
                'nullable',
                'email',
                //'unique:users,email,' . $id . ',id',
            ],
            'username' => [
                'required',
                'min:8',
                'unique:users,username,' . $id . ',id',
            ],
            'password' => [
                //'required',
                'min:8',
            ],
            'roles' => [
                'array',
                'exists:roles,name'
            ],
        ];

        // Si es cero, se esta agregando un registro
        if ($id == 0) {
            $rules = array_merge($rules, [
                'roles' => ['required'],
                'password' => ['required']
            ]);
        }




        // Profile
        $rules = array_merge($rules, [
            'profile.identity_document_id' => [
                'required',
            ],
            'profile.number_id'            => [
                'required',
                'min:8',
                'max:15',
                'unique:profiles,number_id,' . $profile_id . ',id',
            ],
            'profile.phone'                => [
                'nullable',
                'min:6',
                'max:12'
            ],
            'profile.address'              => [
                'nullable',
                'max:255'
            ],
        ]);

        return $rules;
    }

    public function attributes()
    {
        return [
            'name'                  => 'nombre',
            'username'              => 'usuario',
            'password'              => 'contraseña',
            'email'                 => 'correo',
            'profile.identity_document_type_id' => 'tipo documento',
            'profile.number_id'     => 'numero documento',
            'profile.phone'         => 'telefono',
            'profile.address'       => 'direccion',
        ];
    }
}
