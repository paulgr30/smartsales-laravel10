<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll()
    {
        $resources = Product::ofIsActive(true)->oldest('name')->with('unit')->get();
        return response()->json($resources);
    }

    public function getByCriteria(Request $request)
    {
        $resources = Product::ofName($request->name)
            ->latest()
            ->with('category', 'unit')
            ->paginate($request->per_page);
        return response()->json($resources);
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito'], 201);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->update();
        return response()->json(['message' => 'Operacion realizada con exito']);
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
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
