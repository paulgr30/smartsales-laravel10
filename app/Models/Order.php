<?php

namespace App\Models;

use App\Models\ScopeTraits\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, OrderScope;

    protected $fillable = [
        'customer_id', 'user_id', 'order_status_id',
        'number', 'canceled',
    ];
    protected $casts = [
        'canceled' => 'boolean',
    ];


    // Relaciones
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'price')
                    ->using(OrderProduct::class);
    }
}
