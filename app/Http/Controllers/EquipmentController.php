<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentChildResource;
use App\Http\Resources\EquipmentParentResource;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\FilesByEquipment;
use App\Models\PositionEquipment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\TemplateProcessor;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('lists')->whereNull('parent_equipment_id')->get();
        return EquipmentResource::collection($equipments);
    }

    public function show(Request $request)
    {
        $equipments = Equipment::where('parent_equipment_id', $request->all()['parent_equipment_id'])->get();
        return EquipmentChildResource::collection($equipments);
    }

    public function show_parent(Request $request)
    {
        $equipment = Equipment::find($request->all()['parent_equipment_id']);
        return new EquipmentParentResource($equipment);
    }

    public function create(Request $request)
    {
        $equipment = $request->post();

        if (is_null($request->file('image')))
        {
            $path = null;
        }
        else
        {
            $path = $request->file('image')->store('image_plan_reference', ['disk' => 'public']);
            if (str_ends_with($path, 'c'))
            {
                shell_exec('sudo lowriter --convert-to docx' .
                    Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $path);
            }
        }

        $equip = Equipment::create([
            'equipment_name' => $equipment['equipment_name'],
            'have_equipment' => 1,
        ]);

        FilesByEquipment::create([
            'equipment_id' => $equip->id,
            'image_plan_reference' => isset($path) ? "/storage/" . $path : $path,
        ]);

        return $equip->id;
    }

    public function create_child(Request $request)
    {
        $equipment = $request->post();

        if ($equipment['service'])
        {
            Service::create([]);
            Equipment::create([
                'position_on_plan' => $equipment['position_on_plan'],
                'equipment_name' => $equipment['equipment_name'],
                'parent_equipment_id' => $equipment['parent_equipment_id'],
                'service_id' => Service::all()->last()->id,
                'have_equipment' => $equipment['have_equipment'],
            ]);
        }
        else
        {
            Equipment::create([
                'position_on_plan' => $equipment['position_on_plan'],
                'equipment_name' => $equipment['equipment_name'],
                'parent_equipment_id' => $equipment['parent_equipment_id'],
                'have_equipment' => $equipment['have_equipment'],
            ]);
        }
    }

    public function change_child(Request $request)
    {
        $equipment_change = $request->post();

        $equipment = Equipment::find($equipment_change['id']);

        $equipment->position_on_plan = $equipment_change['position_on_plan'];
        $equipment->equipment_name = $equipment_change['equipment_name'];
        $equipment->have_equipment = $equipment_change['have_equipment'];

        if ($equipment_change['service'])
        {
            $equipment->service_id = Service::create([])->id;
        }
        else
        {
            $equipment->service_id = null;
        }

        $equipment->save();
    }

    public function save_name(Request $request)
    {
        $equipment_change = $request->post();

        $equipment = Equipment::find($equipment_change['id']);

        $equipment->equipment_name = $equipment_change['equipment_name'];

        $equipment->save();
    }

    public function delete(Request $request)
    {
        $this->recursive_delete($request->all('id'));
    }

    public function recursive_delete($id)
    {
        Equipment::destroy($id);
        foreach (Equipment::where('parent_equipment_id', $id)->get() as $child_equipment)
        {
            $this->recursive_delete($child_equipment['id']);
        }
        FilesByEquipment::where('equipment_id', $id)->delete();
        PositionEquipment::where('equipment_id', $id)->delete();
    }
}
