<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc', 'name_business', 'address',
        'phone', 'email', 'sales_tax', 'image_url'
    ];
}
