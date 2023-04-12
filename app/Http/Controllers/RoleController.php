<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): string
    {
        $role = Role::all();
        return $role->toJson();
    }

    public function post(Request $request) {
        dd($request);
    }

    public function create(Request $request)
    {
        Role::create($request->all());
    }
}
