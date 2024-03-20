<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function getAll()
    {
        $resources = Unit::ofIsActive(true)
            ->oldest('name')
            ->get(['id', 'name']);
        return response()->json($resources, 200);
    }

    public function getByCriteria(Request $request)
    {
        $resources = Unit::ofName($request->name)
            ->latest()
            ->paginate($request->per_page);
        return response()->json($resources, 200);
    }

    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function toggleStatus(Unit $unit)
    {
        $unit->is_active = !$unit->is_active;
        $unit->update();
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
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
