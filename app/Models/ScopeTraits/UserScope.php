<?php

namespace App\Models\ScopeTraits;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

trait UserScope
{
    public function scopeOfNotAuthenticatedUser($query)
    {
        $query->where('id', '!=', Auth::user()->id);
    }

    // Usuarios que no tenga solo el rol cliente
    public function scopeOfNotHaveCustomerRole($query)
    {
        $rolesExceptCustomer = Role::where('name', '!=', 'Cliente')->pluck('id');
        $query->whereHas('roles', function ($query) use ($rolesExceptCustomer) {
            $query->whereIn('id', $rolesExceptCustomer);
        });
    }

    // Filtrar por numero identificacion
    public function scopeOfProfileNumberId($query, $value)
    {
        if ($value) {
            $query->orWhereRelation('profile', 'number_id', $value);
        }
    }
}
