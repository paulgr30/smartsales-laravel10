<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdentityDocumentRequest;
use App\Models\IdentityDocument;
use Illuminate\Http\Request;

class IdentityDocumentController extends Controller
{
    public function getAll()
    {
        $resources = IdentityDocument::ofIsActive(true)
            ->oldest('name')
            ->get(['id', 'name']);
        return response()->json($resources);
    }

    public function getByCriteria(Request $request)
    {
        $resources = IdentityDocument::ofName($request->name)
            ->latest()
            ->paginate($request->per_page);
        return response()->json($resources);
    }

    public function store(IdentityDocumentRequest $request)
    {
        IdentityDocument::create($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(IdentityDocumentRequest $request, IdentityDocument $identityDocument)
    {
        $identityDocument->update($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function toggleStatus(IdentityDocument $identityDocument)
    {
        $identityDocument->is_active = !$identityDocument->is_active;
        $identityDocument->update();
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function destroy(IdentityDocument $identityDocument)
    {
        try {
            $identityDocument->delete();
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
