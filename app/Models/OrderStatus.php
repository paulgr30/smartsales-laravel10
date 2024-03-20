<?php

namespace App\Models;

use App\Models\ScopeTraits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory, BaseScope;

    protected $fillable = ['name', 'is_active'];
    protected $casts = ['is_active' => 'boolean',];
}
