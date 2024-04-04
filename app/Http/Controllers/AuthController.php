<?php

namespace App\Http\Controllers;

use App\Http\Requests\{LoginRequest, PasswordAuthRequest, ProfileAuthRequest};
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::attempt($request->validated())) {
            return response()->json(['error' => 'Estas credenciales no coinciden con nuestros registros'], 401);
        }
        $user = Auth::user();
        // Si no tiene roles cerramos sesion y negamos el acceso
        if ($user->roles->isEmpty()) {
            $this->logout();
            return response()->json(['error' => 'No tiene autorizacion para acceder'], 401);
        }
        // Retornamos los datos
        $resource = [
            'token' => [
                'type'    => 'bearer',
                'value'  => $token,
                'expires_in'    => Auth::factory()->getTTL() * 60,
            ],
            'user'  => [
                'name'          => $user->name,
                'roles'         => $user->getRoleNames(),
                'permissions'   => $user->getAllPermissions()
            ]
        ];

        return response()->json($resource);
    }

    public function logout()
    {
        Auth::invalidate();
        Auth::logout(true);
    }

    public function getProfile()
    {
        return response()->json(Auth::user());
    }

    public function updateProfile(ProfileAuthRequest $request)
    {
        // Obtenemos el usuario autenticado
        $user = Auth::user();
        // Actualizamos el usuario
        $user->update($request->validated());

        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function changePassword(PasswordAuthRequest $request)
    {
        // Obtenemos el usuario autenticado
        $user = Auth::user();
        // Encrptamos y actualizamos el password
        //$user->update(['password' => Hash::make($new_password)]);
        $user->update(['password' => $request->new_password]);

        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function refreshToken()
    {
        $token = [
            'token' => [
                'type' => 'bearer',
                'value' => Auth::refresh(true, true),
                'expires_in' => Auth::factory()->getTTL() * 60
            ]
        ];

        return response()->json($token);
    }
}
