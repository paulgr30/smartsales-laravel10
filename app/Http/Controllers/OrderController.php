<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getByCriteria(Request $request)
    {
        $resources = Order::ofNumber($request->number)
            ->ofCustomerName($request->name)
            ->ofCustomerNumberId($request->number_id)
            ->ofStatus($request->status_id)
            ->latest()
            ->with('customer', 'user', 'orderStatus', 'products.unit')
            ->paginate($request->per_page);
        return response()->json($resources);
    }

    public function store(OrderRequest $request)
    {
        $items = $request->validated()['items'];
        $products = [];
        $total = 0;

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price = $product->wholesale_price == 0 || $item['quantity'] < $product->wholesale_quantity
                ? $product->sale_price
                : $product->wholesale_price;


            $products[$item['product_id']] = [
                'quantity' => $item['quantity'],
                'price'    => $price //$item['price'],
            ];
            $total += $item['quantity'] * $price;
        }

        $response = null;
        DB::transaction(function () use ($request, $products, $total, &$response) {
            $order = Order::create($request->validated());
            $order->products()->attach($products);

            $response = response()->json([
                'message' => 'Operacion realizada con exito',
                'number' => $order->number,
                'total' => $total
            ], 201);
        });
        return $response;
    }

    public function update(OrderRequest $request, Order $order)
    {
        $items = $request->validated()['items'];
        $products = [];
        $total = 0;

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price = $product->wholesale_price == 0 || $item['quantity'] < $product->wholesale_quantity
                ? $product->sale_price
                : $product->wholesale_price;

            $products[$item['product_id']] = [
                'quantity' => $item['quantity'],
                'price'    => $price
            ];
            $total += $item['quantity'] * $price;
        }


        $response = null;
        DB::transaction(function () use (
            $request,
            $order,
            $products,
            $total,
            &$response
        ) {
            $order->update($request->validated());
            $order->products->each(function ($item) {
                $item->pivot->delete();
            });
            $order->products()->sync($products);

            $response = response()->json([
                'message' => 'Operacion realizada con exito',
                'number' => $order->number,
                'total' => $total
            ], 201);
        });
        return $response ?? response()->json(['message' => 'Error al actualizar el pedido'], 500);
    }

    public function canceled(Order $order)
    {
        if ($order->order_status_id != 1) {
            return response()->json([
                'message' => 'La orden ' . $order->number
                    . ' no se puede anular, ya ha sido procesada anteriormente'
            ], 400);
        }

        $order->canceled = true;
        $order->update();
        return response()->json(['message' => 'Operacion realizada con exito']);
    }
}
