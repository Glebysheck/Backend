<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionEquipmentResource;
use App\Models\Equipment;
use App\Models\PositionEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionEquipmentController extends Controller
{
    public function create(Request $request)
    {
        $position_equipment = $request->post();

        $group_id = Str::random(9);

        PositionEquipment::create([
            'group_id' => $group_id,
            'position' => $position_equipment['position'],
            'equipment_id' => $position_equipment['equipment_id'],
            'date_last_service_id' => date('Y-m-d'),
        ]);

        $equipments = Equipment::where('parent_equipment_id', $position_equipment['equipment_id'])->get('id')->toArray();

        foreach ($equipments as $equipment)
        {
            PositionEquipment::recursive($group_id, $equipment['id']);
        }
    }

    public function index(Request $request)
    {
        $position_equipment = PositionEquipment::where('equipment_id', $request->all()['equipment_id'])
            ->whereNull('locations_id')
            ->get();
        return PositionEquipmentResource::collection($position_equipment);
    }

    public function show(Request $request)
    {
        $position_equipment = PositionEquipment::where('equipment_id', $request->all()['equipment_id'])->get();
        return PositionEquipmentResource::collection($position_equipment);
    }

    public function add_to_location(Request $request)
    {
        $position_equipment_change = $request->post();

        $position_equipment = PositionEquipment::find($position_equipment_change['id']);

        $position_equipment->locations_id = $position_equipment_change['locations_id'];

        $position_equipment->save();
    }

    public function remove_from_location(Request $request)
    {
        $position_equipment_change = $request->post();

        $position_equipment = PositionEquipment::find($position_equipment_change['id']);

        $position_equipment->locations_id = null;

        $position_equipment->save();
    }

    public function show_by_location(Request $request)
    {
        $position_equipment = PositionEquipment::where('locations_id', $request->all()['locations_id'])->get();
        return PositionEquipmentResource::collection($position_equipment);
    }

    public function change(Request $request)
    {
        $location = PositionEquipment::find($request->post()['id']);

        $location->position = $request->post()['position'];

        $location->save();
    }

    public function delete(Request $request)
    {
        PositionEquipment::where('group_id', $request->all()['group_id'])->delete();
    }
}
