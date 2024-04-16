<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getAll()
    {
        $resources = Role::oldest('name')
            ->get(['id', 'name']);
        return response()->json($resources, 200);
    }
}
