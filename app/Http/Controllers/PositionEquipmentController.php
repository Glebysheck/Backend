<?php

namespace App\Http\Controllers;

use App\Models\PositionEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionEquipmentController extends Controller
{
    public function create(Request $request)
    {
        $position_equipment = $request->post();

        PositionEquipment::create([
            'group_id' => Str::random(9),
            'position' => $position_equipment['position'],
            'equipment_id' => $position_equipment['equipment_id'],
        ]);

        PositionEquipment::recursive(Str::random(9),
            $position_equipment['equipment_id'],
            $position_equipment['position']);
    }
}
