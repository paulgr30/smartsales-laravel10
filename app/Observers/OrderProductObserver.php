<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;


class OrderProductObserver
{
    private $product_id = null;
    private $quantity = 0;
    private $result = null;

    public function created(OrderProduct $orderProduct): void
    {
        $product_id = $orderProduct->product_id;
        $product = Product::find($product_id);

        $product->stock_initial -= $orderProduct->quantity;
        $product->save();
    }

    public function updating(OrderProduct $orderProduct): void
    {
        $order = Order::find($orderProduct->order_id);
        $productOld = $order->products()->find($orderProduct->product_id);

        $this->result = $productOld->pivot->quantity - $orderProduct->quantity;
    }

    public function updated(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $product->stock_initial += $this->result;
        $product->save();
    }

    public function deleting(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $product->stock_initial += $orderProduct->quantity;
        $product->save();
    }
}
