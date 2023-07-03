<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionEquipmentDetailResource;
use App\Http\Resources\PositionEquipmentParentResource;
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

        while (PositionEquipment::where('group_id', $group_id)->exists())
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

    public function detail_show(Request $request)
    {
        $detail_position = [];
        foreach (Equipment::where('parent_equipment_id', PositionEquipment::find($request->all()['id'])['equipment_id'])
                     ->get()
                     ->toArray()
                 as $position)
        {
            $detail_position['data'][] = PositionEquipmentDetailResource::collection(PositionEquipment::where('equipment_id', $position['id'])
                ->where('group_id', PositionEquipment::find($request->all()['id'])['group_id'])->get());
        }
        return $detail_position;
    }

    public function show_parent(Request $request)
    {
        $position_equipment = PositionEquipment::find($request->all()['id']);
        return new PositionEquipmentParentResource($position_equipment);
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
        $position_equipment = PositionEquipment::where('locations_id', $request->all()['locations_id'])
            ->orderByRaw('-position_on_location DESC')
            ->get();
        return PositionEquipmentResource::collection($position_equipment);
    }

    public function change(Request $request)
    {
        $location = PositionEquipment::find($request->post()['id']);

        $location->position = $request->post()['position'];

        $location->save();
    }


    public function change_position_on_location(Request $request)
    {
        $position_equipment_change = $request->post()['positionsArr'];

        $position_on_location = 1;

        foreach ($position_equipment_change as $position)
        {
            $position_equipment = PositionEquipment::find($position['id']);

            $position_equipment->position_on_location = $position_on_location;

            $position_equipment->save();
            $position_on_location++;
        }
    }

    public function delete(Request $request)
    {
        PositionEquipment::where('group_id', $request->all()['group_id'])->delete();
    }
}
