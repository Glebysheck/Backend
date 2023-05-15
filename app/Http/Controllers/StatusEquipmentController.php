<?php

namespace App\Http\Controllers;

use App\Models\StatusEquipment;
use Illuminate\Http\Request;

class StatusEquipmentController extends Controller
{
    public function create(Request $request)
    {
        StatusEquipment::create($request->all());
    }
}
