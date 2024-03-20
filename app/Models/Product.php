<?php

namespace App\Models;

use App\Models\ScopeTraits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BaseScope;

    protected $fillable = [
        'category_id', 'unit_id', 'name',
        'stock_initial', 'stock_min', 'purchase_price',
        'sale_price', 'wholesale_price', 'wholesale_quantity', 'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];




    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price')
            ->using(OrderProduct::class);
    }
}
