<?php

namespace App\Http\Controllers;

use App\Models\PositionEquipment;
use Illuminate\Http\Request;

class PositionEquipmentController extends Controller
{
    public function create(Request $request)
    {
        $position_equipment = $request->post();

        PositionEquipment::create([
            'group_id' => $position_equipment['group_id'],
            'position' => $position_equipment['position'],
            'equipment_id' => $position_equipment['equipment_id'],
        ]);
    }
}
