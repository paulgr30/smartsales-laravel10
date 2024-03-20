<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        $resources = Category::ofIsActive(true)
            ->oldest('name')
            ->get(['id', 'name']);
        return response()->json($resources, 200);
    }

    public function getByCriteria(Request $request)
    {
        $resources = Category::ofName($request->name)
            ->latest()
            ->paginate($request->per_page);
        return response()->json($resources, 200);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function toggleStatus(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->update();
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
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
