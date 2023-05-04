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
        $equipments = Equipment::with('lists')->whereNull('parent_equipment_id')->get();
        return EquipmentResource::collection($equipments);
    }

    public function create(Request $request)
    {
        $equipment = $request->post();

        if ($equipment['service'] == true)
        {
            Service::create([]);
            $path = $request->file('image')->store('image_plan_reference');
            Equipment::create([
                'equipment_name' => $equipment['equipment_name'],
                'image_plan_reference' => $path,
                'service_id' => Service::all()->last()->id,
            ]);
            dd($path);
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
        return response('Null', 4030);
    }
}
