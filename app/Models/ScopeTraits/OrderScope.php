<?php

namespace App\Models\ScopeTraits;

trait OrderScope
{
    // Filtrar por numero de la orden
    public function scopeOfNumber($query, $value)
    {
        if ($value) {
            $query->where('number', $value);
        }
    }

    // Filtrar por nombre del cliente
    public function scopeOfCustomerName($query, $value)
    {
        if ($value) {
            $query->orWhereRelation('customer', 'name', "like",  "%{$value}%");
        }
    }

    // Buscar por numero de documento de identidad
    public function scopeOfCustomerNumberId($query, $value)
    {
        if ($value) {
            $query->orWhereRelation('customer.profile', 'number_id',  $value);
        }
    }

    // Filtrar por estado
    public function scopeOfStatus($query, $value)
    {
        if ($value) {
            return $query->where('order_status_id', $value);
        }
    }
}
