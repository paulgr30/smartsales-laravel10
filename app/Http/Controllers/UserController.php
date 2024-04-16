<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileNumberIdRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAll()
    {
        $resources = User::role('Cliente')
            ->oldest('name')
            ->with(['profile:user_id,number_id'])
            ->get(['id', 'name']);
        return response()->json($resources, 200);
    }

    public function getByCriteria(Request $request)
    {
        $resources = User::ofNotHaveCustomerRole()
            ->ofName($request->name)
            ->ofProfileNumberId($request->number_id)
            ->latest()
            ->with(['profile.identityDocument', 'roles:name'])
            ->paginate($request->per_page);
        return response()->json($resources);
    }

    public function getByNumberId(ProfileNumberIdRequest $request)
    {
        $numberId = $request->validated()['profile']['number_id'];
        $resource = User::ofProfileNumberId($numberId)
            ->with(['profile.identityDocument', 'roles:name'])
            ->first();
        return response()->json($resource);
    }

    public function store(UserRequest $request)
    {
        $dataValidated = $request->validated();
        DB::transaction(function () use ($dataValidated) {
            $user = User::create($dataValidated);
            $user->profile()->create($dataValidated['profile']);
            $user->assignRole($dataValidated['roles']);
        });
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(UserRequest $request, User $user)
    {
        $dataValidated = $request->validated();
        DB::transaction(function () use ($dataValidated, $user) {
            $user->update($dataValidated);
            $user->profile()->update($dataValidated['profile']);
            $user->syncRoles($dataValidated['roles']);
        });
        return response()->json(['message' => 'Operacion realizada con exito'], 200);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Operacion realizada con exito']);
        } catch (\Exception $e) {

            $message = ($e->getCode() == '23000')
                ? [
                    'success' => false,
                    'message' => 'El registro esta siendo usado, no se puede eliminar'
                ]
                : [
                    'success' => false,
                    'message' => 'Error inesperado, no se pudo eliminar el registro'
                ];

            return response()->json(
                $message,
                ($e->getCode() == '23000') ? 400 : 500
            );
        }
    }
}
