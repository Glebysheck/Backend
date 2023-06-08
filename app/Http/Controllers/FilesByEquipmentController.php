<?php

namespace App\Http\Controllers;

use App\Models\FilesByEquipment;
use Illuminate\Http\Request;

class FilesByEquipmentController extends Controller
{
    public function create(Request $request)
    {
        $file = $request->post();
        $path = $request->file('image')->store('image_plan_reference', ['disk' => 'public']);

        FilesByEquipment::create([
            'equipment_id' => $file['equipment_id'],
            'image_plan_reference' => isset($path) ? "/storage/" . $path : $path,
        ]);
    }

    public function delete(Request $request)
    {

    }
}
