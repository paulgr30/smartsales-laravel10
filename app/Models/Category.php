<?php

namespace App\Models;

use App\Models\ScopeTraits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, BaseScope;

    protected $fillable = ['name','is_active'];
    protected $dates = ['deleted_at'];
    protected $casts = ['is_active' => 'boolean',];
}
