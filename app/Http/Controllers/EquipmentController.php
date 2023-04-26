<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::whereNull('parent_equipment_id')->get();
        return EquipmentResource::collection($equipments);
    }

    public function create(Request $request)
    {
        $equipment = $request->post();

        if ($equipment['service'] == true)
        {
            Service::create([]);
            Equipment::create([
                'equipment_name' => $equipment['equipment_name'],
                'image_plan_reference' => $equipment['image_plan_reference'],
                'parent_equipment_id' => $equipment['parent_equipment_id'],
                'service_id' => Service::all()->last()->id,
            ]);
        }
        else
        {
            Equipment::create([
                'equipment_name' => $equipment['equipment_name'],
                'image_plan_reference' => $equipment['image_plan_reference'],
            ]);
        }
//        foreach ($equipments as $equipment)
//        {
//
//        }
    }
}
