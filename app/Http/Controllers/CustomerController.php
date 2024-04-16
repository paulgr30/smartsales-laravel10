<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileNumberIdRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function getAll()
    {
        $resources = User::role('Cliente')
            ->ofNotAuthenticatedUser()
            ->oldest('name')
            ->with(['profile:user_id,number_id'])
            ->get(['id', 'name']);
        return response()->json($resources, 200);
    }

    public function getByCriteria(Request $request)
    {
        $resources = User::role('Cliente')
            ->ofName($request->name)
            ->ofProfileNumberId($request->number_id)
            ->latest()
            ->with('profile.identityDocument')
            ->paginate($request->per_page);
        return response()->json($resources);
    }

    public function getByNumberId(ProfileNumberIdRequest $request)
    {
        $resource = User::ofProfileNumberId(
            $request->validated()['profile']['number_id']
        )
            ->with('profile.identityDocument')
            ->first();
        return response()->json($resource);
    }

    public function store(CustomerRequest $request)
    {
        $dataValidated = $request->validated();
        $dataValidated['username'] = $dataValidated['profile']['number_id'];
        $dataValidated['password'] = $dataValidated['profile']['number_id'];

        DB::transaction(function () use ($dataValidated) {
            $customer = User::create($dataValidated);
            $customer->profile()->create($dataValidated['profile']);
            $customer->assignRole('Cliente');
        });
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(CustomerRequest $request, User $customer)
    {
        DB::transaction(function () use ($request, $customer) {
            $customer->update($request->validated());
            $customer->profile()->update($request->validated()['profile']);
            $customer->assignRole('Cliente');
        });
        return response()->json(['message' => 'Operacion realizada con exito'], 200);
    }

    public function destroy(User $customer)
    {
        try {
            DB::transaction(function () use ($customer) {
                $customer->delete();
            });
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
