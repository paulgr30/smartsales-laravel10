<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    public function creating(Order $order): void
    {
        $order->user_id = Auth::user()->id;
        $order->order_status_id = 1;

        $lastOrderNumber = Order::max('number');

        if ($lastOrderNumber !== null) {
            $order->number = $lastOrderNumber + 1;
        } else {
            $order->number = 1;
        }
    }
}
