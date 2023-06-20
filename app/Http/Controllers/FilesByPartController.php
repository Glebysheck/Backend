<?php

namespace App\Http\Controllers;

use App\Models\FilesByPart;
use Illuminate\Http\Request;

class FilesByPartController extends Controller
{
    public function create(Request $request)
    {
        $file = $request->post();
        $path = $request->file('image')->store('image_plan_reference_by_part', ['disk' => 'public']);

        FilesByPart::create([
            'type_part_id' => $file['type_part_id'],
            'image_plan_reference' => isset($path) ? "/storage/" . $path : $path,
        ]);
    }

    public function delete(Request $request)
    {
        FilesByPart::destroy($request->all()['id']);
    }
}
