<?php

namespace App\Models\ScopeTraits;

use Illuminate\Support\Facades\DB;

trait BaseScope
{
    // Filtrar por nombre
    public function scopeOfName($query, $value)
    {
        if ($value) {
            $query->where('name', 'like', "%{$value}%");
        }
    }

    // Filtrar por nombre completo
    public function scopeOfFullName($query, $value)
    {
        if ($value) {
            $query->where(
                DB::raw("CONCAT(surname, ' ',name)"),
                'like',
                "%{$value}%"
            )
                ->orWhere(
                    DB::raw(
                        "CONCAT(name, ' ',surname)"
                    ),
                    'like',
                    "%{$value}%"
                );
        }
    }


    // Filtrar por estado activo
    public function scopeOfIsActive($query, $value)
    {
        if ($value) {
            return $query->where('is_active', $value);
        }
    }
}
