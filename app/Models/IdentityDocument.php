<?php

namespace App\Models;

use App\Models\ScopeTraits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model
{
    use HasFactory, BaseScope;

    protected $fillable = ['name', 'description', 'is_active'];
    protected $dates = ['deleted_at'];
    protected $casts = ['is_active' => 'boolean',];
}
