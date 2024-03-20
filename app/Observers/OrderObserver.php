<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function creating(Order $order): void
    {
        $order->user_id = 1;
        $order->order_status_id = 1;

        $lastOrderNumber = Order::max('number');

        if ($lastOrderNumber !== null) {
            $order->number = $lastOrderNumber + 1;
        } else {
            $order->number = 1;
        }
    }
}
