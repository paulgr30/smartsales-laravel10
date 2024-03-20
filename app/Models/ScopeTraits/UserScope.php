<?php

namespace App\Models\ScopeTraits;

use Illuminate\Support\Facades\DB;

trait UserScope
{
    // Filtrar por numero identificacion
    public function scopeOfProfileNumberId($query, $value)
    {
        if ($value) {
            $query->orWhereRelation('profile', 'number_id', $value);
        }
    }
}
